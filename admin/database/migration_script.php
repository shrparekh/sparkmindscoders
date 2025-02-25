<?php
require 'vendor/autoload.php'; // Load the Composer autoloader
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$dbname= $_ENV['DB_DATABASE'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
// migration.php
class Database
{
    protected $pdo;

    public function __construct($host, $username, $password)
    {
        $dsn = "mysql:host=$host;charset=utf8mb4";

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function databaseExists($dbname)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :dbname");
            $stmt->bindParam(':dbname', $dbname);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (PDOException $e) {
            die("Error checking database existence: " . $e->getMessage());
        }
    }

    public function createDatabase($dbname)
    {
        if (!$this->databaseExists($dbname)) {
            try {
                $this->exec("CREATE DATABASE $dbname");
                echo "Database '$dbname' created successfully.\n";
            } catch (PDOException $e) {
                die("Error creating database: " . $e->getMessage());
            }
        } else {
            echo "Database '$dbname' already exists.\n";
        }
    }

    public function exec($sql)
    {
        try {
            $this->pdo->exec($sql);
            echo "SQL executed successfully\n";
        } catch (PDOException $e) {
            die("Error executing SQL: " . $e->getMessage());
        }
    }

    public function selectDatabase($dbname)
    {
        try {
            $this->pdo->exec("USE $dbname");
            echo "Database selected: $dbname\n";
        } catch (PDOException $e) {
            die("Error selecting database: " . $e->getMessage());
        }
    }
}



class CreateImportSQLTable
{

    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function importSQL($filename)
    {
        // Check if the file exists
        if (!file_exists($filename)) {
            die("Error: SQL file not found.");
        }

        // Read the SQL file
        $sql = file_get_contents($filename);

        // Check if the SQL content was successfully read
        if ($sql === false) {
            die("Error: Unable to read SQL file.");
        }

        // Remove SQL comments from the SQL content
        $sql = preg_replace('/--.*\n/', '', $sql); // Remove single-line comments
        $sql = preg_replace('/\/\*.*?\*\//s', '', $sql); // Remove multi-line comments

        // Split the SQL content into individual queries
        $queries = explode(';', $sql);

        // Execute each query
        foreach ($queries as $query) {
            // Skip empty queries
            if (trim($query) != '') {
                try {
                    $this->db->exec($query);
                } catch (PDOException $e) {
                    die("Error executing SQL: " . $e->getMessage());
                }
            }
        }

        echo "Import successful!";
    }
}

class CreatePostsTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
            CREATE TABLE posts (
     id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    content TEXT,
    image VARCHAR(255),
    image_alt VARCHAR(255),
    meta_title VARCHAR(255),
    meta_descriptions TEXT,
    meta_keyword VARCHAR(255),
    featured_image VARCHAR(255),
    featured_image_alt VARCHAR(255),
    comment_status ENUM('open', 'closed') DEFAULT 'open',
    views INT UNSIGNED DEFAULT 0,
    category_id INT,
    published BOOLEAN DEFAULT false,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
            )
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: Posts table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS posts";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: Posts table dropped.\n";
    }
}

class CreateCategoriesTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
            CREATE TABLE categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                published BOOLEAN DEFAULT false,
                user_id INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: Categories table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS categories";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: Categories table dropped.\n";
    }
}

class CreateCodesTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
            CREATE TABLE codes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                message TEXT NOT NULL,
                type VARCHAR(50) NOT NULL,
                published BOOLEAN DEFAULT false,
                user_id INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: Codes table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS codes";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: Codes table dropped.\n";
    }
}

class CreateTagsTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
            CREATE TABLE tags (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                tag_content TEXT,
                page_url JSON,
                published BOOLEAN DEFAULT false,
                user_id INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: Tags table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS tags";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: Tags table dropped.\n";
    }
}

class CreatePostTagTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
            CREATE TABLE post_tag (
                id INT AUTO_INCREMENT PRIMARY KEY,
                post_id INT NOT NULL,
                tag_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
                FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
            )
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: post_tag table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS post_tag";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: post_tag table dropped.\n";
    }
}

class CreateRolesTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
            CREATE TABLE roles (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: Roles table created.\n";

        // Insert queries to add roles
        $insertSql = "
            INSERT INTO roles (name) VALUES
            ('admin'),
            ('seo')
        ";

        // Execute the SQL to insert roles
        $this->db->exec($insertSql);
        echo "Roles added successfully.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS roles";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: Roles table dropped.\n";
    }
}

class CreateSeoMetasTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
            CREATE TABLE seo_metas (
                id INT AUTO_INCREMENT PRIMARY KEY,
                page VARCHAR(255) NOT NULL,
                title VARCHAR(255),
                descriptions TEXT,
                keywords TEXT,
                featured_image_url VARCHAR(255),
                published BOOLEAN DEFAULT false,
                user_id INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: SeoMetas table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS seo_metas";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: SeoMetas table dropped.\n";
    }
}

class CreateUsersTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                isProfile BOOLEAN DEFAULT false,
                role_id INT,
                assign_role_id INT,
                mini_avatar VARCHAR(255),
                avatar VARCHAR(255),
                url_fb VARCHAR(255),
                url_insta VARCHAR(255),
                url_twitter VARCHAR(255),
                url_linkedin VARCHAR(255),
                remember_token VARCHAR(100),
                published BOOLEAN DEFAULT false,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (role_id) REFERENCES roles(id),
                FOREIGN KEY (assign_role_id) REFERENCES assign_roles(id)
            )
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: Users table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS users";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: Users table dropped.\n";
    }
}

class CreateAssignRoleTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
            CREATE TABLE assign_roles (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: assign_roles table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS assign_roles";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: assign_roles table dropped.\n";
    }
}

class CreateLeadContactsTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
            CREATE TABLE lead_contacts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                subject VARCHAR(255) NOT NULL,
                message TEXT NOT NULL,
                phone VARCHAR(20) NOT NULL,
                accept_time VARCHAR(20) NULL,
                user_id INT NOT NULL,
                status TINYINT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: lead_contacts table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS lead_contacts";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: lead_contacts table dropped.\n";
    }
}

// Website Requirements
class CreateClientsTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
            CREATE TABLE clients (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                image VARCHAR(255) NOT NULL,
                image_alt VARCHAR(255) NOT NULL,
                published TINYINT DEFAULT 0,
                user_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: clients table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS clients";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: clients table dropped.\n";
    }
}
class CreatePortfolioTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
            CREATE TABLE portfolio (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                image VARCHAR(255) NOT NULL,
                image_alt VARCHAR(255) NOT NULL,
                published TINYINT DEFAULT 0,
                user_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: portfolio table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS portfolio";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: portfolio table dropped.\n";
    }
}
class CreateTestimonialTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
            CREATE TABLE testimonial (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                comment VARCHAR(255) NOT NULL,
                image VARCHAR(255) NOT NULL,
                image_alt VARCHAR(255) NOT NULL,
                published TINYINT DEFAULT 0,
                user_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: testimonial table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS testimonial";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: testimonial table dropped.\n";
    }
}
class CreateLoginHistoryTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
                CREATE TABLE login_history (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        login_time DATETIME NOT NULL,
        logout_time DATETIME,
        ip_address VARCHAR(255),
        FOREIGN KEY (user_id) REFERENCES users(id)
    )
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: login_history table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS login_history";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: login_history table dropped.\n";
    }
}
class CreateActionLogsTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
                CREATE TABLE action_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action_time DATETIME NOT NULL,
    action_description TEXT,
    ip_address VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
)
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: action_logs table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS action_logs";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: action_logs table dropped.\n";
    }
}
class CreateCompaniesTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
                CREATE TABLE companies (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                page_url VARCHAR(255) NOT NULL,
                published TINYINT DEFAULT 0,
                user_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: companies table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS companies";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: companies table dropped.\n";
    }
}
class CreateRelatedSearchesTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
                CREATE TABLE related_searches (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                tag_content TEXT,
                page_url JSON,
                published BOOLEAN DEFAULT false,
                user_id INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
)
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: related_searches table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS related_searches";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: related_searches table dropped.\n";
    }
}
class CreateFaqTable
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        // Define the database schema changes to be applied when migrating up
        $sql = "
                CREATE TABLE faq (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                faq_content TEXT,
                page_url JSON,
                published BOOLEAN DEFAULT false,
                user_id INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
)
        ";

        // Execute the SQL to create the table
        $this->db->exec($sql);
        echo "Migration up: faq table created.\n";
    }

    public function down()
    {
        // Define the actions to be taken when rolling back the migration
        $sql = "DROP TABLE IF EXISTS faq";

        // Execute the SQL to drop the table
        $this->db->exec($sql);
        echo "Migration down: faq table dropped.\n";
    }
}





$database = new Database($host, $username, $password);

// Create database if it doesn't exist
if (!$database->databaseExists($dbname)) {
    $database->createDatabase($dbname);
}

// Select the database
$database->selectDatabase($dbname);

// users
$role = new CreateRolesTable($database);
$assign_role = new CreateAssignRoleTable($database);
$users = new CreateUsersTable($database);
// post
$categories = new CreateCategoriesTable($database);
$tag = new CreateTagsTable($database);
$post = new CreatePostsTable($database);
$post_tag = new CreatePostTagTable($database);
// seo
$seo = new CreateSeoMetasTable($database);
$code = new CreateCodesTable($database);
// 
$importSQL = new CreateImportSQLTable($database);
// contact
$lead_contacts = new CreateLeadContactsTable($database);
// portfolio
$portfolio = new CreatePortfolioTable($database);
// 
$testimonial = new CreateTestimonialTable($database);
$login_history = new CreateLoginHistoryTable($database);
$action_logs = new CreateActionLogsTable($database);
$companies = new CreateCompaniesTable($database);
$clients = new CreateClientsTable($database);
$related_searches = new CreateRelatedSearchesTable($database);
$faq = new CreateFaqTable($database);


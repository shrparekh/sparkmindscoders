$(document).ready(function () {
    let postTable = $('#postTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/service/postsShow.php",
            "type": "POST",
            "dataSrc": function (json) {
                console.log(json); // Log the response to the console
                return json.data;
            },
            "error": function (xhr, error, thrown) {
                console.log(xhr.responseText); // Log the response text to the console
                alert("Error occurred while processing your request.");
            }
        },
        "columns": [{
            "data": null,
            "render": function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        }, // Sr.No
        {
            "data": "created_at",
            "render": function (data) {
                // Parse the date string into a Date object
                const dateObj = new Date(data);

                // Extract date components
                const day = dateObj.getDate();
                const month = dateObj.toLocaleString('default', {
                    month: 'short'
                });
                const year = dateObj.getFullYear() % 100; // Extract last two digits of the year

                // Extract time components
                let hour = dateObj.getHours();
                const minute = dateObj.getMinutes();
                const meridiem = hour >= 12 ? "PM" : "AM";

                // Convert hour to 12-hour format
                hour = hour % 12;
                hour = hour ? hour : 12; // Handle midnight (0 hours)

                // Format the date and time string
                const formattedDateString = `${day} ${month} ${year} <br/> ${hour}:${minute.toString().padStart(2, '0')} ${meridiem}`;

                return formattedDateString;
            }
        },

        {
            "data": "title"
        }, // Title
        {
            "data": "image",
            "render": function (data, type, row) {
                return '<a href="' + data + '" data-lightbox="image-' + row.id + '"><img src="' + data + '" alt="' + row.title + '" style="width:100px"></a>';
            }
        }, // Image
        {
            "data": "category_name"
        }, // Category
        {
            "data": "tags",
            "render": function (data, type, row) {
                // Create a button to trigger the modal
                var button = `<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal${row.id}">View</button>`;

                // Create the modal structure
                var modal = `
        <div class="modal fade" id="exampleModal${row.id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel${row.id}" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel${row.id}">Tags</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">`;

                // Add tags to the modal body
                modal += row.tags.map(tag => `<a href="" class="custom-tag"><div>${tag}</div></a>`).join('');

                // Close the modal structure
                modal += `
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>`;


                // Return the button HTML (modal is already appended to the body)
                return button + modal;
            }
        },

        {
            "data": "views"
        }, // Views
        {
            "data": null,
            "render": function (data, type, row) {
                // Create a button to trigger the modal
                var button = `<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#metaModal${row.id}">View</button>`;

                // Create the modal structure
                var modal = `
        <div class="modal fade" id="metaModal${row.id}" tabindex="-1" role="dialog" aria-labelledby="metaModalLabel${row.id}" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="metaModalLabel${row.id}">Meta Tags</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">`;

                // Add tags to the modal body
                modal += `Meta Title : ${row.meta_title}`;
                modal += `<br/>Meta Descriptions : ${row.meta_descriptions}`;
                modal += `<br/>Meta Keyword : ${row.meta_keyword}`;
                modal += `<br/>Featured Image: <img src="${row.featured_image}" alt="${row.featured_image_alt}"/>`;
                modal += `<br/>Featured Image Alt: ${row.featured_image_alt}`;

                // Close the modal structure
                modal += `
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>`;


                // Return the button HTML (modal is already appended to the body)
                return button + modal;
            }
        },
        {
            "data": "published"
        }, // User
        {
            "data": "user_name"
        }, // User
        {
            "data": "updated_at",
            "render": function (data) {
                // Parse the date string into a Date object
                const dateObj = new Date(data);

                // Extract date components
                const day = dateObj.getDate();
                const month = dateObj.toLocaleString('default', {
                    month: 'short'
                });
                const year = dateObj.getFullYear() % 100; // Extract last two digits of the year

                // Extract time components
                let hour = dateObj.getHours();
                const minute = dateObj.getMinutes();
                const meridiem = hour >= 12 ? "PM" : "AM";

                // Convert hour to 12-hour format
                hour = hour % 12;
                hour = hour ? hour : 12; // Handle midnight (0 hours)

                // Format the date and time string
                const formattedDateString = `${day} ${month} ${year} <br/> ${hour}:${minute.toString().padStart(2, '0')} ${meridiem}`;

                return formattedDateString;
            }
        },
        {
            "data": null,
            "render": function (data, type, row) {
                return `<div style="display:flex;">
                        <button class="btn btn-success" type="button" onclick="logAndNavigate(event, '/admin/post/edit?id=${row.id}','Edit post Id ${row.id} Button Click');"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-blue" type="button" onclick="logAndNavigate(event, '/preview/latest-news-blog-updates/details/${row.slug}','preview Post Slug ${row.slug} Button Click','_blank');"><i class="fa-regular fa-eye"></i></button>
                        <form class="delete-form" style="display: inline;">
                                <input type="hidden" name="id" value="${row.id}">
                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                              </form>`;
            }
        } // Manage
        ],
        "paging": true, // Enable pagination
        "info": true, // Show "Showing 1 to 10 of X entries"
        "searching": true, // Enable the search bar
        "order": false,
        "stateSave": true,
        // "dom": 'Bfrtip', // Add buttons to the DOM
        // "buttons": [
        //     'colvis' // Column visibility button
        // ],
        // "colReorder": true // Enable column reordering
    });

    // Event delegation for delete buttons
    $('#postTable').on('click', '.delete-form button[type="submit"]', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (!confirm('Are you sure you want to delete this item?')) {
            return; // Stop if user cancels
        }

        var formData = new FormData($(this).closest('form')[0]);

        $.ajax({
            type: "POST",
            url: "/admin/service/postsDelete.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    postTable.ajax.reload(); // Reload DataTable on success
                } else {
                    if (response.type === 'warning') {
                        toastr.warning(response.message, 'Warning'); // Show warning message
                    } else {
                        toastr.error(response.message, 'Error'); // Show error message
                    }
                }
            },
            error: function (xhr, status, error) {
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            }
        });
    });
    // Initialize DataTable
    var categoryTable = $('#categoryTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/service/categoriesShow.php",
            "type": "POST",
            "dataSrc": function (json) {
                console.log(json); // Log the response to the console
                return json.data;
            },
            "error": function (xhr, error, thrown) {
                console.log(xhr.responseText); // Log the response text to the console
                alert("Error occurred while processing your request.");
            }
        },
        "columns": [
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }, // Sr.No
            {
                "data": "created_at",
                "render": function (data) {
                    return formatDate(new Date(data));
                }
            }, // Created At
            { "data": "name" }, // Name
            { "data": "slug" }, // Slug
            { "data": "published" }, // Slug
            { "data": "user_name" }, // User
            {
                "data": "updated_at",
                "render": function (data) {
                    return formatDate(new Date(data));
                }
            }, // Updated At
            {
                "data": null,
                "render": function (data, type, row) {
                    var editButton = `<button class="btn btn-success" onclick="logAndNavigate(event, '/admin/post/categories/edit?id=${row.id}','Edit categories Id ${row.id} Button Click');"><i class="fas fa-edit"></i></button>`;
                    var deleteForm = `<form class="delete-form" style="display: inline;">
                                <input type="hidden" name="id" value="${row.id}">
                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                              </form>`;
                    return editButton + deleteForm;
                }
            } // Manage
        ],
        "paging": true, // Enable pagination
        "info": true, // Show "Showing 1 to 10 of X entries"
        "searching": true, // Enable the search bar
        "order": false,
        "stateSave": true,
        "stateSave": true
    });



    // Event delegation for delete buttons (since they are dynamically created)
    $('#categoryTable').on('click', '.delete-form button[type="submit"]', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (!confirm('Are you sure you want to delete this item?')) {
            return; // Stop if user cancels
        }

        var formData = new FormData($(this).closest('form')[0]);

        $.ajax({
            type: "POST",
            url: "/admin/service/categoriesDelete.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    categoryTable.ajax.reload(); // Reload DataTable on success
                } else {
                    if (response.type === 'warning') {
                        toastr.warning(response.message, 'Warning'); // Show warning message
                    } else {
                        toastr.error(response.message, 'Error'); // Show error message
                    }
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            }
        });
    });

    // Initialize DataTable
    var tagTable = $('#tagTable').DataTable({
        "processing": true, // Show processing indicator
        "serverSide": true, // Enable server-side processing
        "ajax": {
            "url": "/admin/service/tagsShow.php", // URL to fetch data from
            "type": "POST", // HTTP method
            "dataSrc": function (json) {
                console.log(json); // Log the response to the console
                return json.data; // Return the data array for DataTable to use
            },
            "error": function (xhr, error, thrown) {
                console.log(xhr.responseText); // Log the response text to the console
                alert("Error occurred while processing your request."); // Show alert on error
            }
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } }, // Sr.No
            { "data": "created_at", "render": function (data) { return formatDate(new Date(data)); } }, // Created At
            { "data": "name" }, // Name
            { "data": "slug" }, // Slug
            { "data": "post_count" }, // Post Count
            { "data": "published" }, // Slug
            { "data": "user_name" }, // User
            { "data": "updated_at", "render": function (data) { return formatDate(new Date(data)); } }, // Updated At
            {
                "data": null,
                "render": function (data, type, row) {
                    var editButton = `<button class="btn btn-success" onclick="logAndNavigate(event, '/admin/post/tags/edit?id=${row.id}','Edit tags Id ${row.id} Button Click');"><i class="fas fa-edit"></i></button>`;
                    var deleteButton = `<form class="delete-form" style="display: inline;">
                                <input type="hidden" name="id" value="${row.id}">
                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                              </form>`;
                    return editButton + deleteButton;
                }
            } // Manage
        ],
        "paging": true, // Enable pagination
        "info": true, // Show "Showing 1 to 10 of X entries"
        "searching": true, // Enable the search bar
        "order": false,
        "stateSave": true,
        "stateSave": true
    });

    // Event delegation for delete buttons (since they are dynamically created)
    $('#tagTable').on('click', '.delete-form button[type="submit"]', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (!confirm('Are you sure you want to delete this item?')) {
            return; // Stop if user cancels
        }

        var formData = new FormData($(this).closest('form')[0]);

        $.ajax({
            type: "POST",
            url: "/admin/service/tagsDelete.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    tagTable.ajax.reload(); // Reload DataTable on success
                } else {
                    if (response.type === 'warning') {
                        toastr.warning(response.message, 'Warning'); // Show warning message
                    } else {
                        toastr.error(response.message, 'Error'); // Show error message
                    }
                }
            },
            error: function (xhr, status, error) {
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            }
        });
    });



    // Seo Page 
    var metaTable = $('#metaTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/service/seoMetaShow.php",
            "type": "POST",
            "dataSrc": function (json) {
                console.log(json); // Log the response to the console
                return json.data;
            },
            "error": function (xhr, error, thrown) {
                console.log(xhr.responseText); // Log the response text to the console
                alert("Error occurred while processing your request.");
            }
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } }, // Sr.No
            {
                "data": "created_at",
                "render": function (data) {
                    // Parse the date string into a Date object
                    const dateObj = new Date(data);

                    // Format the date and time string
                    const formattedDateString = formatDate(dateObj);

                    return formattedDateString;
                }
            }, // Created At
            {
                "data": "page",
                "render": function (data, type, row, meta) {
                    return '<a href="' + data + '" target="_blank"><div>' + data + '</div></a>';
                }
            },
            {
                "data": "page",
                "render": function (data, type, row, meta) {
                    // Remove the protocol, domain, and www
                    let cleanedUrls = data.replace(/^(https?:\/\/)?(www\.)?[^\/]+/, "");

                    // Replace hyphens with spaces and convert to lowercase
                    cleanedUrls = cleanedUrls.replace(/-/g, ' ').toLowerCase();

                    // Remove leading slashes
                    cleanedUrls = cleanedUrls.replace(/^\//, '');

                    if (cleanedUrls === "") {
                        return "home";
                    } else if (cleanedUrls.startsWith("services/")) {
                        return cleanedUrls.replace("services/", "");
                    } else {
                        return cleanedUrls;
                    }
                }
            },



            { "data": "title" }, // Title
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    // Ensure the title field is present
                    if (row.title) {
                        // Calculate the character count of the title
                        var titleCharCount = row.title.length;
                        let className;
                        let status;
                        if (titleCharCount < 50) {
                            className = "text-danger"
                            status = "(To Short)"
                        } else if (titleCharCount > 60) {
                            className = "text-danger"
                            status = "(To Long)"
                        } else {
                            className = "text-success"
                            status = ""
                        }

                        // Return the title with character count in parentheses
                        return `<span class = ${className}>${titleCharCount} characters <br/> ${status}</span>`;
                    } else {
                        // Handle cases where the title might be missing
                        return '0 characters';
                    }
                }
            },
            { "data": "descriptions" }, // Descriptions
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    // Ensure the title field is present
                    if (row.title) {
                        // Calculate the character count of the title
                        var titleCharCount = row.descriptions.length;
                        let className;
                        let status;
                        if (titleCharCount < 150) {
                            className = "text-danger"
                            status = "(To Short)"
                        } else if (titleCharCount > 160) {
                            className = "text-danger"
                            status = "(To Long)"
                        } else if (titleCharCount >= 150 && titleCharCount <= 160) {
                            className = "text-success"
                            status = ""
                        } else {
                            className = "text-warning"
                            status = ""
                        }

                        // Return the title with character count in parentheses
                        return `<span class = ${className}>${titleCharCount} characters <br/> ${status}</span>`;
                    } else {
                        // Handle cases where the title might be missing
                        return '0 characters';
                    }
                }
            },
            { "data": "keywords" }, // Keywords
            {
                "data": "featured_image_url",
                "render": function (data, type, row) {
                    return `<a href="${data}" data-lightbox="image-${row.id}"><img src="${data}" alt="${row.title}" style="width:100px"></a>`;
                }
            }, // Featured Image
            {
                "data": "published"
            },
            { "data": "user_name" }, // User
            {
                "data": "updated_at",
                "render": function (data) {
                    // Parse the date string into a Date object
                    const dateObj = new Date(data);

                    // Format the date and time string
                    const formattedDateString = formatDate(dateObj);

                    return formattedDateString;
                }
            }, // Updated At
            {
                "data": null,
                "render": function (data, type, row) {
                    return `<button class="btn btn-success" type="button" onclick="logAndNavigate(event, '/admin/seo/pages/edit?id=${row.id}','Edit seo ON pages Id ${row.id} Button Click');"><i class="fas fa-edit"></i></button>
                            <form class="delete-form" style="display: inline;">
                                <input type="hidden" name="id" value="${row.id}">
                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                              </form>`;
                }
            } // Manage
        ],
        "paging": true, // Enable pagination
        "info": true, // Show "Showing 1 to 10 of X entries"
        "searching": true, // Enable the search bar
        "order": false,
        "stateSave": true
    });

    // Event delegation for delete buttons (since they are dynamically created)
    $('#metaTable').on('click', '.delete-form button[type="submit"]', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (!confirm('Are you sure you want to delete this item?')) {
            return; // Stop if user cancels
        }

        var formData = new FormData($(this).closest('form')[0]);

        $.ajax({
            type: "POST",
            url: "/admin/service/seoMetaDelete.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    metaTable.ajax.reload(); // Reload DataTable on success
                } else {
                    if (response.type === 'warning') {
                        toastr.warning(response.message, 'Warning'); // Show warning message
                    } else {
                        toastr.error(response.message, 'Error'); // Show error message
                    }
                }
            },
            error: function (xhr, status, error) {
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            }
        });
    });

    // Initialize DataTable
    var table = $('#technicalTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/service/seoTechShow.php",
            "type": "POST",
            "dataSrc": function (json) {
                console.log(json); // Log the response to the console
                return json.data;
            },
            "error": function (xhr, error, thrown) {
                console.log(xhr.responseText); // Log the response text to the console
                alert("Error occurred while processing your request.");
            }
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } }, // Sr.No
            { "data": "created_at", "render": function (data) { return formatDate(new Date(data)); } }, // Created At
            { "data": "name" }, // Name
            { "data": "message" }, // Message
            { "data": "type" }, // Type
            {
                "data": "published"
            },
            { "data": "user_name" }, // User
            { "data": "updated_at", "render": function (data) { return formatDate(new Date(data)); } }, // Updated At
            {
                "data": null,
                "render": function (data, type, row) {
                    var editButton = `<button class="btn btn-success" onclick="logAndNavigate(event, '/admin/seo/technical/edit?id=${row.id}','Edit seo Code Insert Id ${row.id} Button Click');"><i class="fas fa-edit"></i></button>`;
                    var deleteForm = `<form class="delete-form" style="display: inline;">
                                <input type="hidden" name="id" value="${row.id}">
                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                              </form>`;
                    return editButton + deleteForm;
                }
            } // Manage
        ],
        "paging": true, // Enable pagination
        "info": true, // Show "Showing 1 to 10 of X entries"
        "searching": true, // Enable the search bar
        "order": false,
        "stateSave": true


    });

    // Event delegation for delete buttons (since they are dynamically created)
    $('#technicalTable').on('click', '.delete-form button[type="submit"]', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (!confirm('Are you sure you want to delete this item?')) {
            return; // Stop if user cancels
        }

        var formData = new FormData($(this).closest('form')[0]);

        $.ajax({
            type: "POST",
            url: "/admin/service/codesDelete.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    table.ajax.reload(); // Reload DataTable on success
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function (xhr, status, error) {
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            }
        });
    });

    // Initialize DataTable
    var usersTable = $('#usersTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/service/usersShow.php",
            "type": "POST",
            "dataSrc": function (json) {
                console.log(json); // Log the response to the console
                return json.data;
            },
            "error": function (xhr, error, thrown) {
                console.log(xhr.responseText); // Log the response text to the console
                alert("Error occurred while processing your request.");
            }
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } }, // Sr.No
            { "data": "created_at", "render": function (data) { return formatDate(new Date(data)); } }, // Created At
            { "data": "name" }, // Name
            { "data": "email" }, // Message
            { "data": "role_name" }, // Type
            {
                "data": "published"
            },
            { "data": "assign_roles_name" }, // User
            { "data": "updated_at", "render": function (data) { return formatDate(new Date(data)); } }, // Updated At
            {
                "data": null,
                "render": function (data, type, row) {
                    var editButton = `<button class="btn btn-success" onclick="logAndNavigate(event, '/admin/users/edit?id=${row.id}','Edit users Id ${row.id} Button Click');"><i class="fas fa-edit"></i></button>`;
                    var deleteForm = `<form class="delete-form" style="display: inline;">
                                <input type="hidden" name="id" value="${row.id}">
                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                              </form>`;
                    return editButton + deleteForm;
                }
            } // Manage
        ],
        "paging": true, // Enable pagination
        "info": true, // Show "Showing 1 to 10 of X entries"
        "searching": true, // Enable the search bar
        "order": false,
        "stateSave": true // Default ordering on the second column (action_time) in descending order
    });

    // Event delegation for delete buttons (since they are dynamically created)
    $('#usersTable').on('click', '.delete-form button[type="submit"]', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (!confirm('Are you sure you want to delete this item?')) {
            return; // Stop if user cancels
        }

        var formData = new FormData($(this).closest('form')[0]);

        $.ajax({
            type: "POST",
            url: "/admin/service/usersDelete.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    usersTable.ajax.reload(); // Reload DataTable on success
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function (xhr, status, error) {
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            }
        });
    });

    // lead_contacts
    var leadContactsTable = $('#leadContactsTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/service/lead_contactShow.php", // Adjust the URL to your PHP script
            "type": "POST",
            "dataSrc": function (json) {
                console.log(json); // Log the response to the console
                return json.data;
            },
            "error": function (xhr, error, thrown) {
                console.log(xhr.responseText); // Log the response text to the console
                alert("Error occurred while processing your request.");
            }
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } }, // Sr.No
            { "data": "created_at", "render": function (data) { return formatDate(new Date(data)); } }, // Created At
            { "data": "name" }, // Name
            { "data": "email" }, // Email
            { "data": "phone" }, // Phone
            { "data": "subject" }, // Subject
            { "data": "message" }, // Message
            { "data": "accept_time", "render": function (data) { return data == null ? "-" : formatDate(new Date(data)); } }, // Updated At
            { "data": "user_name" }, // User ID (if shown)
            { "data": "updated_at", "render": function (data) { return formatDate(new Date(data)); } }, // Updated At
            {
                "data": null,
                "render": function (data, type, row) {
                    console.log(row);
                    var editButton = `<form class="edit-form" style="display: inline;">
                    <input type="hidden" name="id" value="${row.id}">
                    <input type="hidden" name="user_id" value="${row.user_id}">
                    <input type="hidden" name="status" value="1">
                    <button class="btn btn-success"  type="submit"><i class="fa-solid fa-check"></i></button>
                    </form>
                    `;
                    var deleteForm = `<form class="delete-form" style="display: inline;">
                                    <input type="hidden" name="id" value="${row.id}">
                                    <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                                  </form>`;
                    return row.status == 1 ? deleteForm : editButton + deleteForm;
                }
            } // Manage
        ],
        "paging": true, // Enable pagination
        "info": true, // Show "Showing 1 to 10 of X entries"
        "searching": true, // Enable the search bar
        "order": false,
        "stateSave": true // Default ordering on the second column (action_time) in descending order
    });

    // Event delegation for delete buttons (since they are dynamically created)
    $('#leadContactsTable').on('click', '.delete-form button[type="submit"]', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (!confirm('Are you sure you want to delete this item?')) {
            return; // Stop if user cancels
        }

        var formData = new FormData($(this).closest('form')[0]);

        $.ajax({
            type: "POST",
            url: "/admin/service/lead_contactDelete.php", // Adjust the URL for delete operation
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    leadContactsTable.ajax.reload(); // Reload DataTable on success
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function (xhr, status, error) {
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            }
        });
    });

    // Event delegation for edit buttons (since they are dynamically created)
    $('#leadContactsTable').on('click', '.edit-form button[type="submit"]', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (!confirm('Are you sure you want to Update this item?')) {
            return; // Stop if user cancels
        }

        var formData = new FormData($(this).closest('form')[0]);

        $.ajax({
            type: "POST",
            url: "/admin/service/lead_contactUpdate.php", // Adjust the URL for delete operation
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    leadContactsTable.ajax.reload(); // Reload DataTable on success
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function (xhr, status, error) {
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            }
        });
    });

    // clients
    var clientsTable = $('#clientsTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/service/website_req_clientsShow.php", // Adjust the URL to your PHP script
            "type": "POST",
            "dataSrc": function (json) {
                return json.data;
            },
            "error": function (xhr, error, thrown) {
                console.log(xhr.responseText); // Log the response text to the console
                alert("Error occurred while processing your request.");
            }
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } }, // Sr.No
            { "data": "created_at", "render": function (data) { return formatDate(new Date(data)); } }, // Created At
            { "data": "name" },
            {
                "data": "image",
                "render": function (data, type, row) {
                    return `<a href="${data}" data-lightbox="image-${row.id}"><img src="${data}" alt="${row.title}" style="width:100px"></a>`;
                }
            },
            { "data": "image_alt" },
            { "data": "published" },
            { "data": "user_name" },

            { "data": "updated_at", "render": function (data) { return formatDate(new Date(data)); } }, // Updated At
            {
                "data": null,
                "render": function (data, type, row) {
                    var editButton = `<button class="btn btn-success" onclick="logAndNavigate(event, '/admin/website/clients/edit?id=${row.id}','Edit clients Id ${row.id} Button Click');"><i class="fas fa-edit"></i></button>`;
                    var deleteForm = `<form class="delete-form" style="display: inline;">
                                <input type="hidden" name="id" value="${row.id}">
                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                              </form>`;
                    return editButton + deleteForm;
                }
            } // Manage
        ],
        "paging": true, // Enable pagination
        "info": true, // Show "Showing 1 to 10 of X entries"
        "searching": true, // Enable the search bar
        "order": false,
        "stateSave": true // Default ordering on the second column (action_time) in descending order
    });

    // Event delegation for delete buttons
    $('#clientsTable').on('click', '.delete-form button[type="submit"]', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (!confirm('Are you sure you want to delete this client?')) {
            return; // Stop if user cancels
        }

        var formData = new FormData($(this).closest('form')[0]);

        $.ajax({
            type: "POST",
            url: "/admin/service/website_req_clientsDelete.php", // Adjust the URL for delete operation
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    clientsTable.ajax.reload(); // Reload DataTable on success
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function (xhr, status, error) {
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            }
        });
    });

    // Portfolio
    var portfolioTable = $('#portfolioTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/service/website_req_portfolioShow.php", // Adjust the URL to your PHP script
            "type": "POST",
            "dataSrc": function (json) {
                return json.data;
            },
            "error": function (xhr, error, thrown) {
                console.log(xhr.responseText); // Log the response text to the console
                alert("Error occurred while processing your request.");
            }
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } }, // Sr.No
            { "data": "created_at", "render": function (data) { return formatDate(new Date(data)); } }, // Created At
            { "data": "name" },
            {
                "data": "image",
                "render": function (data, type, row) {
                    return `<a href="${data}" data-lightbox="image-${row.id}"><img src="${data}" alt="${row.title}" style="width:100px"></a>`;
                }
            },
            { "data": "image_alt" },
            { "data": "published" },
            { "data": "user_name" },

            { "data": "updated_at", "render": function (data) { return formatDate(new Date(data)); } }, // Updated At
            {
                "data": null,
                "render": function (data, type, row) {
                    var editButton = `<button class="btn btn-success" onclick="logAndNavigate(event, '/admin/website/portfolio/edit?id=${row.id}','Edit portfolio Id ${row.id} Button Click');"><i class="fas fa-edit"></i></button>`;
                    var deleteForm = `<form class="delete-form" style="display: inline;">
                                <input type="hidden" name="id" value="${row.id}">
                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                              </form>`;
                    return editButton + deleteForm;
                }
            } // Manage
        ],
        "paging": true, // Enable pagination
        "info": true, // Show "Showing 1 to 10 of X entries"
        "searching": true, // Enable the search bar
        "order": false,
        "stateSave": true // Default ordering on the second column (action_time) in descending order
    });

    // Event delegation for delete buttons
    $('#portfolioTable').on('click', '.delete-form button[type="submit"]', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (!confirm('Are you sure you want to delete this client?')) {
            return; // Stop if user cancels
        }

        var formData = new FormData($(this).closest('form')[0]);

        $.ajax({
            type: "POST",
            url: "/admin/service/website_req_portfolioDelete.php", // Adjust the URL for delete operation
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    portfolioTable.ajax.reload(); // Reload DataTable on success
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function (xhr, status, error) {
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            }
        });
    });

    // testimonials
    var testimonialTable = $('#testimonialTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/service/website_req_testimonialShow.php", // Adjust the URL to your PHP script
            "type": "POST",
            "dataSrc": function (json) {
                return json.data;
            },
            "error": function (xhr, error, thrown) {
                console.log(xhr.responseText); // Log the response text to the console
                alert("Error occurred while processing your request.");
            }
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } }, // Sr.No
            { "data": "created_at", "render": function (data) { return formatDate(new Date(data)); } }, // Created At
            { "data": "name" },
            {
                "data": "image",
                "render": function (data, type, row) {
                    return `<a href="${data}" data-lightbox="image-${row.id}"><img src="${data}" alt="${row.title}" style="width:100px"></a>`;
                }
            },
            { "data": "image_alt" },
            { "data": "published" },
            { "data": "user_name" },

            { "data": "updated_at", "render": function (data) { return formatDate(new Date(data)); } }, // Updated At
            {
                "data": null,
                "render": function (data, type, row) {
                    var editButton = `<button class="btn btn-success" onclick="logAndNavigate(event, '/admin/website/testimonial/edit?id=${row.id}','Edit testimonial Id ${row.id} Button Click');"><i class="fas fa-edit"></i></button>`;
                    var deleteForm = `<form class="delete-form" style="display: inline;">
                                <input type="hidden" name="id" value="${row.id}">
                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                              </form>`;
                    return editButton + deleteForm;
                }
            } // Manage
        ],
        "paging": true, // Enable pagination
        "info": true, // Show "Showing 1 to 10 of X entries"
        "searching": true, // Enable the search bar
        "order": false,
        "stateSave": true // Default ordering on the second column (action_time) in descending order
    });

    // Event delegation for delete buttons
    $('#testimonialTable').on('click', '.delete-form button[type="submit"]', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (!confirm('Are you sure you want to delete this client?')) {
            return; // Stop if user cancels
        }

        var formData = new FormData($(this).closest('form')[0]);

        $.ajax({
            type: "POST",
            url: "/admin/service/website_req_testimonialDelete.php", // Adjust the URL for delete operation
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    testimonialTable.ajax.reload(); // Reload DataTable on success
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function (xhr, status, error) {
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            }
        });
    });

    // companiesTable
    var companiesTable = $('#companiesTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/service/website_req_companiesShow.php", // Adjust the URL to your PHP script
            "type": "POST",
            "dataSrc": function (json) {
                return json.data;
            },
            "error": function (xhr, error, thrown) {
                console.log(xhr.responseText); // Log the response text to the console
                alert("Error occurred while processing your request.");
            }
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } }, // Sr.No
            { "data": "created_at", "render": function (data) { return formatDate(new Date(data)); } }, // Created At
            { "data": "name" },
            { "data": "page_url" },
            { "data": "published" },
            { "data": "user_name" },

            { "data": "updated_at", "render": function (data) { return formatDate(new Date(data)); } }, // Updated At
            {
                "data": null,
                "render": function (data, type, row) {
                    var editButton = `<button class="btn btn-success" onclick="logAndNavigate(event, '/admin/website/companies/edit?id=${row.id}','Edit companies Id ${row.id} Button Click');"><i class="fas fa-edit"></i></button>`;
                    var deleteForm = `<form class="delete-form" style="display: inline;">
                                <input type="hidden" name="id" value="${row.id}">
                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                              </form>`;
                    return editButton + deleteForm;
                }
            } // Manage
        ],
        "paging": true, // Enable pagination
        "info": true, // Show "Showing 1 to 10 of X entries"
        "searching": true, // Enable the search bar
        "order": false,
        "stateSave": true // Default ordering on the second column (action_time) in descending order
    });

    // Event delegation for delete buttons
    $('#companiesTable').on('click', '.delete-form button[type="submit"]', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (!confirm('Are you sure you want to delete this client?')) {
            return; // Stop if user cancels
        }

        var formData = new FormData($(this).closest('form')[0]);

        $.ajax({
            type: "POST",
            url: "/admin/service/website_req_companiesDelete.php", // Adjust the URL for delete operation
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    companiesTable.ajax.reload(); // Reload DataTable on success
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function (xhr, status, error) {
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            }
        });
    });

    // historyTable
    $('#historyTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/service/historyShow.php", // Adjust the URL to your PHP script
            "type": "POST",
            "dataSrc": function (json) {
                return json.data;
            },
            "error": function (xhr, error, thrown) {
                console.log(xhr.responseText); // Log the response text to the console
                alert("Error occurred while processing your request.");
            }
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } }, // Sr.No
            { "data": "action_time", "render": function (data) { return formatDate(new Date(data)); } }, // Created At
            { "data": "action_description" },
            { "data": "ip_address" },
            { "data": "published" },
            { "data": "user_name" },
            { "data": "role_name" },
        ],
        "paging": true, // Enable pagination
        "info": true, // Show "Showing 1 to 10 of X entries"
        "searching": true, // Enable the search bar
        "order": false,
        "stateSave": true // Default ordering on the second column (action_time) in descending order
    });

    // Related Searches
    var related_searchesTable = $('#related_searchesTable').DataTable({
        "processing": true, // Show processing indicator
        "serverSide": true, // Enable server-side processing
        "ajax": {
            "url": "/admin/service/related_searchesShow.php", // URL to fetch data from
            "type": "POST", // HTTP method
            "dataSrc": function (json) {
                console.log(json); // Log the response to the console
                return json.data; // Return the data array for DataTable to use
            },
            "error": function (xhr, error, thrown) {
                console.log(xhr.responseText); // Log the response text to the console
                alert("Error occurred while processing your request."); // Show alert on error
            }
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } }, // Sr.No
            { "data": "created_at", "render": function (data) { return formatDate(new Date(data)); } }, // Created At
            { "data": "name" }, // Name
            { "data": "tag_content" }, // tag_content
            // { "data": "page_url" }, // page_url
            {
                "data": "page_url",
                "render": function (data, type, row) {

                    let cleanedUrls = row.page_url.map(url => {
                        if (url === "/") {
                            return "home";
                        } else if (url.startsWith("/services/")) {
                            return url.replace("/services/", "");
                        } else {
                            return url.replace(/^\//, '');
                        }
                    });
                    // Create a button to trigger the modal
                    var button = `<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal${row.id}">View</button>`;

                    // Create the modal structure
                    var modal = `
            <div class="modal fade" id="exampleModal${row.id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel${row.id}" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel${row.id}">Pages</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">`;

                    // Add tags to the modal body
                    modal += cleanedUrls.map(tag => `<a href="" class="custom-tag"><div>${tag}</div></a>`).join('');

                    // Close the modal structure
                    modal += `
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>`;


                    // Return the button HTML (modal is already appended to the body)
                    return button + modal;
                }
            },
            { "data": "published" }, // published
            { "data": "user_name" }, // User
            { "data": "updated_at", "render": function (data) { return formatDate(new Date(data)); } }, // Updated At
            {
                "data": null,
                "render": function (data, type, row) {
                    var editButton = `<button class="btn btn-success" onclick="logAndNavigate(event, '/admin/website/related-searches/edit?id=${row.id}','Edit related searches Id ${row.id} Button Click');"><i class="fas fa-edit"></i></button>`;
                    var deleteButton = `<form class="delete-form" style="display: inline;">
                                <input type="hidden" name="id" value="${row.id}">
                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                              </form>`;
                    return editButton + deleteButton;
                }
            } // Manage
        ],
        "paging": true, // Enable pagination
        "info": true, // Show "Showing 1 to 10 of X entries"
        "searching": true, // Enable the search bar
        "order": false,
        "stateSave": true // Default ordering on the second column (action_time) in descending order
    });

    // Event delegation for delete buttons (since they are dynamically created)
    $('#related_searchesTable').on('click', '.delete-form button[type="submit"]', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (!confirm('Are you sure you want to delete this item?')) {
            return; // Stop if user cancels
        }

        var formData = new FormData($(this).closest('form')[0]);

        $.ajax({
            type: "POST",
            url: "/admin/service/related_searchesDelete.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    related_searchesTable.ajax.reload(); // Reload DataTable on success
                } else {
                    if (response.type === 'warning') {
                        toastr.warning(response.message, 'Warning'); // Show warning message
                    } else {
                        toastr.error(response.message, 'Error'); // Show error message
                    }
                }
            },
            error: function (xhr, status, error) {
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            }
        });
    });

    // faqTable
    var faqTable = $('#faqTable').DataTable({
        "processing": true, // Show processing indicator
        "serverSide": true, // Enable server-side processing
        "ajax": {
            "url": "/admin/service/faqShow.php", // URL to fetch data from
            "type": "POST", // HTTP method
            "dataSrc": function (json) {
                console.log(json); // Log the response to the console
                return json.data; // Return the data array for DataTable to use
            },
            "error": function (xhr, error, thrown) {
                console.log(xhr.responseText); // Log the response text to the console
                alert("Error occurred while processing your request."); // Show alert on error
            }
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } }, // Sr.No
            { "data": "created_at", "render": function (data) { return formatDate(new Date(data)); } }, // Created At
            { "data": "name" }, // Name
            { "data": "faq_content" }, // tag_content
            {
                "data": "page_url"
            },
            { "data": "published" }, // published
            { "data": "user_name" }, // User
            { "data": "updated_at", "render": function (data) { return formatDate(new Date(data)); } }, // Updated At
            {
                "data": null,
                "render": function (data, type, row) {
                    var editButton = `<button class="btn btn-success" onclick="logAndNavigate(event, '/admin/website/faq/edit?id=${row.id}','Edit related searches Id ${row.id} Button Click');"><i class="fas fa-edit"></i></button>`;
                    var deleteButton = `<form class="delete-form" style="display: inline;">
                                <input type="hidden" name="id" value="${row.id}">
                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                              </form>`;
                    return editButton + deleteButton;
                }
            } // Manage
        ],
        "paging": true, // Enable pagination
        "info": true, // Show "Showing 1 to 10 of X entries"
        "searching": true, // Enable the search bar
        "order": false,
        "stateSave": true // Default ordering on the second column (action_time) in descending order
    });

    // Event delegation for delete buttons (since they are dynamically created)
    $('#faqTable').on('click', '.delete-form button[type="submit"]', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (!confirm('Are you sure you want to delete this item?')) {
            return; // Stop if user cancels
        }

        var formData = new FormData($(this).closest('form')[0]);

        $.ajax({
            type: "POST",
            url: "/admin/service/faqDelete.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    faqTable.ajax.reload(); // Reload DataTable on success
                } else {
                    if (response.type === 'warning') {
                        toastr.warning(response.message, 'Warning'); // Show warning message
                    } else {
                        toastr.error(response.message, 'Error'); // Show error message
                    }
                }
            },
            error: function (xhr, status, error) {
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            }
        });
    });




});

// Function to open the modal
function openModal(title, content, keyword, image, postId) {
    const modalContainer = document.getElementById(`modalContainer_${postId}`);
    const modalTitle = document.getElementById(`modalTitle_${postId}`);
    const modalContent = document.getElementById(`modalContent_${postId}`);
    const modalkeyword = document.getElementById(`modalkeyword_${postId}`);
    const modalImage = document.getElementById(`modalImage_${postId}`);
    modalTitle.textContent = title;
    modalContent.textContent = content;
    modalkeyword.textContent = keyword;
    modalImage.innerHTML = `<img src="${image}" alt="${title}">`;
    modalContainer.classList.remove('hidden');
}

// Function to close the modal
function closeModal(modalId) {
    const modalContainer = document.getElementById(modalId);
    modalContainer.classList.add('hidden');
}

// Date formatting function
function formatDate(utcDateString) {
    // Create a Date object from the UTC date string
    const utcDate = new Date(utcDateString);

    // Convert UTC date to IST date
    const istOffset = 5.5 * 60 * 60 * 1000; // IST is UTC+5:30
    const istDate = new Date(utcDate.getTime() + istOffset);

    // Extract date components
    const day = istDate.getDate();
    const month = istDate.toLocaleString('default', { month: 'short' });
    const year = istDate.getFullYear() % 100; // Extract last two digits of the year

    // Extract time components
    let hour = istDate.getHours();
    const minute = istDate.getMinutes();
    const meridiem = hour >= 12 ? "PM" : "AM";

    // Convert hour to 12-hour format
    hour = hour % 12;
    hour = hour ? hour : 12; // Handle midnight (0 hours)

    // Format the date and time string
    const formattedDateString = `${day} ${month} ${year} ${hour}:${minute.toString().padStart(2, '0')} ${meridiem}`;

    return formattedDateString;
}


function htmlspecialchars(str) {
    if (typeof str !== "string") {
        return str;
    }
    return str.replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}



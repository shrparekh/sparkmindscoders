// Seo Technical
$(document).ready(function () {

    // Check for success message in URL and display Toastr notification
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        toastr.success(urlParams.get('success'), 'Success');
    }
    if (window.location.pathname == '/admin/seo/technical/add') {
        // call Api Service
        $("#seo_technical_add").validate({
            // Specify validation rules for each input field
            rules: {
                name: {
                    required: true,
                },
                type: {
                    required: true,
                },

                published: {
                    required: true,
                },
                message: {
                    required: true,
                },

            },
            // Specify error messages for each rule
            messages: {
                name: {
                    required: "Please Enter Your Technical Name",
                },
                type: {
                    required: "Please Select Technical Type",
                },
                published: {
                    required: "Please Select Technical Published",
                },
                message: {
                    required: "Please Enter Your Technical code",
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/codesStore.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }

    if (window.location.pathname.startsWith('/admin/seo/technical/edit')) {
        // edit preview
        function fetchContent(id) {
            $.ajax({
                url: '/admin/service/codesFindbyid.php', // Change to your PHP script URL
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    // console.log('Response:', response);
                    if (response) {
                        $("input[name='id']").val(response.id);
                        $("input[name='name']").val(response.name);
                        setSelectValue("type", response.type);
                        setSelectValue("published", response.published);
                        $("textarea[name='message']").val(response.message);
                    } else {
                        console.error('Response is empty or invalid');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching content:', error);
                }
            });
        }

        function setSelectValue(name, value) {
            var select = $("select[name='" + name + "']");
            select.val(value);
            if (select.val() !== value) {
                select.append(new Option(value, value, true, true));
            }
            select.change();
        }

        // Example: Fetch content when the page loads
        var id = getUrlParameter('id'); // Assuming you have a function to get URL parameters
        if (id) {
            fetchContent(id);
        }

        // Function to get URL parameter by name
        function getUrlParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // edit
        $("#seo_technical_edit").validate({
            // Specify validation rules for each input field
            rules: {
                name: {
                    required: true,
                },
                type: {
                    required: true,
                },

                published: {
                    required: true,
                },
                message: {
                    required: true,
                },

            },
            // Specify error messages for each rule
            messages: {
                name: {
                    required: "Please Enter Your Technical Name",
                },
                type: {
                    required: "Please Select Technical Type",
                },
                published: {
                    required: "Please Select Technical Published",
                },
                message: {
                    required: "Please Enter Your Technical code",
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/codesUpdate.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }

    if (window.location.pathname == '/admin/seo/pages/add') {
        // seo_page_add
        $("#seo_page_add").validate({
            // Specify validation rules for each input field
            rules: {
                page: {
                    required: true,
                },
                title: {
                    required: true,
                },
                descriptions: {
                    required: true,
                },
                keywords: {
                    required: true,
                },
                featured_image_url: {
                    required: true,
                },
                published: {
                    required: true,
                },

            },
            // Specify error messages for each rule
            messages: {
                page: {
                    required: "Please Enter Your Page Url",
                },
                title: {
                    required: "Please Enter Your Meta Title",
                },
                descriptions: {
                    required: "Please Enter Your Meta Descriptions",
                },
                keywords: {
                    required: "Please Enter Your Meta Keywords",
                },
                featured_image_url: {
                    required: "Please Upload A Featured Image",
                },
                published: {
                    required: "Please Enter Your published",
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/seoMetaStore.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }

    if (window.location.pathname.startsWith('/admin/seo/pages/edit')) {
        // edit preview
        function fetchContent(id) {
            $.ajax({
                url: '/admin/service/seometaFindbyid.php', // Change to your PHP script URL
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    console.log('Response:', response);
                    if (response) {
                        $("input[name='id']").val(response.id);
                        $("input[name='page']").val(response.page);
                        $("input[name='title']").val(response.title);
                        $("input[name='descriptions']").val(response.descriptions);
                        $("input[name='keywords']").val(response.keywords);
                        $("input[name='Thumbnail_Image_available']").val(response.featured_image_url);
                        setSelectValue("published", response.published);
                    } else {
                        console.error('Response is empty or invalid');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching content:', error);
                }
            });
        }

        function setSelectValue(name, value) {
            var select = $("select[name='" + name + "']");
            select.val(value);
            if (select.val() !== value) {
                select.append(new Option(value, value, true, true));
            }
            select.change();
        }

        // Example: Fetch content when the page loads
        var id = getUrlParameter('id'); // Assuming you have a function to get URL parameters
        if (id) {
            fetchContent(id);
        }

        // Function to get URL parameter by name
        function getUrlParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // edit
        $("#seo_page_edit").validate({
            // Specify validation rules for each input field
            rules: {
                page: {
                    required: true,
                },
                title: {
                    required: true,
                },
                descriptions: {
                    required: true,
                },
                keywords: {
                    required: true,
                },
                published: {
                    required: true,
                },

            },
            // Specify error messages for each rule
            messages: {
                page: {
                    required: "Please Enter Your Page Url",
                },
                title: {
                    required: "Please Enter Your Meta Title",
                },
                descriptions: {
                    required: "Please Enter Your Meta Descriptions",
                },
                keywords: {
                    required: "Please Enter Your Meta Keywords",
                },
                published: {
                    required: "Please Enter Your published",
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/seoMetaUpdate.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseText)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }

    // categories
    // Function to generate slug from category name
    function generateSlug(categoryName) {
        return categoryName.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
    }

    // Debounce function to limit the rate at which a function can fire
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    if (window.location.pathname == '/admin/post/categories/add') {
        // Function to check slug availability
        function checkSlug(slug) {
            $.ajax({
                type: 'POST',
                url: '/admin/service/checkCategorySlug.php',
                data: { slug: slug },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function (xhr, status, error) {
                    var errorMessage = 'Error: ' + xhr.status + ' - ' + xhr.statusText + '\n' + xhr.responseText;
                    $('#slug_message').text(errorMessage).css('color', 'red');
                }
            });
        }

        // Event listener for category name input
        $('#category_name').on('input', debounce(function () {
            var categoryName = $(this).val();
            var slug = generateSlug(categoryName);
            $('#category_slug').val(slug);

            // Check slug availability
            checkSlug(slug);
        }, 500)); // Adjust the debounce delay as needed (500ms is a good starting point)

        $("#categories_add").validate({
            // Specify validation rules for each input field
            rules: {
                name: {
                    required: true,
                },
                slug: {
                    required: true,
                },
                published: {
                    required: true,
                },

            },
            // Specify error messages for each rule
            messages: {
                name: {
                    required: "Please Enter Your Category Name",
                },
                slug: {
                    required: "Please Enter Your Category Slug",
                },
                published: {
                    required: "Please Enter Your published",
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/categoriesStore.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }
    if (window.location.pathname.startsWith('/admin/post/categories/edit')) {

        // edit preview
        function fetchContent(id) {
            $.ajax({
                url: '/admin/service/categoriesFindbyid.php', // Change to your PHP script URL
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    console.log('Response:', response);
                    if (response) {
                        $("input[name='id']").val(response.id);
                        $("input[name='name']").val(response.name);
                        $("input[name='slug']").val(response.slug);
                        setSelectValue("published", response.published);
                    } else {
                        console.error('Response is empty or invalid');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching content:', error);
                }
            });
        }

        function setSelectValue(name, value) {
            var select = $("select[name='" + name + "']");
            select.val(value);
            if (select.val() !== value) {
                select.append(new Option(value, value, true, true));
            }
            select.change();
        }

        // Example: Fetch content when the page loads
        var id = getUrlParameter('id'); // Assuming you have a function to get URL parameters
        if (id) {
            fetchContent(id);
        }

        // Function to get URL parameter by name
        function getUrlParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // edit
        $("#categories_edit").validate({
            // Specify validation rules for each input field
            rules: {
                name: {
                    required: true,
                },
                slug: {
                    required: true,
                },
                published: {
                    required: true,
                },

            },
            // Specify error messages for each rule
            messages: {
                name: {
                    required: "Please Enter Your Category Name",
                },
                slug: {
                    required: "Please Enter Your Category Slug",
                },
                published: {
                    required: "Please Enter Your published",
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/categoriesUpdate.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }

    // tags
    if (window.location.pathname == '/admin/post/tags/add') {
        // Function to check slug availability
        function checkTagSlug(slug) {
            $.ajax({
                type: 'POST',
                url: '/admin/service/checkTagsSlug.php',
                data: { name: slug },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function (xhr, status, error) {
                    var errorMessage = 'Error: ' + xhr.status + ' - ' + xhr.statusText + '\n' + xhr.responseText;
                    $('#slug_message').text(errorMessage).css('color', 'red');
                }
            });
        }

        // Event listener for category name input
        $('#tag_name').on('input', debounce(function () {
            var categoryName = $(this).val();
            var slug = generateSlug(categoryName);
            $('#tag_slug').val(slug);

            // Check slug availability
            checkTagSlug(categoryName);
        }, 500)); // Adjust the debounce delay as needed (500ms is a good starting point)

        $("#tags_add").validate({
            // Specify validation rules for each input field
            rules: {
                name: {
                    required: true,
                },
                slug: {
                    required: true,
                },
                tag_content: {
                    required: true,
                },
                published: {
                    required: true,
                },
                "page_url[]": {
                    required: true,
                },

            },
            // Specify error messages for each rule
            messages: {
                name: {
                    required: "Please Enter Your Tag Name",
                },
                slug: {
                    required: "Please Enter Your Tag Slug",
                },
                tag_content: {
                    required: "Please Enter Your Related Searches Tag Content",
                },
                "page_url[]": {
                    required: "Please enter at least one Related Searches Pages",
                },
                published: {
                    required: "Please Enter Your published",
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/tagsStore.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }
    if (window.location.pathname.startsWith('/admin/post/tags/edit')) {

        // Function to fetch content based on ID
        function fetchContent(id) {
            $.ajax({
                url: '/admin/service/tagsFindbyid.php', // Change to your PHP script URL
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    console.log('Response:', response);
                    if (response) {
                        $("input[name='id']").val(response.id);
                        $("input[name='name']").val(response.name);
                        $("input[name='slug']").val(response.slug);
                        setSelectValue("published", response.published);
                    } else {
                        console.error('Response is empty or invalid');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching content:', error);
                }
            });
        }
        // Function to set a single select value
        function setSelectValue(name, value) {
            var select = $("select[name='" + name + "']");
            if (select.find("option[value='" + value + "']").length) {
                select.val(value);
            } else {
                select.append(new Option(value, value, true, true));
                select.val(value);
            }
            select.trigger('change');
        }


        // Example: Fetch content when the page loads
        var id = getUrlParameter('id'); // Assuming you have a function to get URL parameters
        if (id) {
            fetchContent(id);
        }

        // Function to get URL parameter by name
        function getUrlParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // Function to check slug availability
        function checkTagSlug(slug) {
            $.ajax({
                type: 'POST',
                url: '/admin/service/checkTagsSlug.php',
                data: { name: slug },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function (xhr, status, error) {
                    var errorMessage = 'Error: ' + xhr.status + ' - ' + xhr.statusText + '\n' + xhr.responseText;
                    $('#slug_message').text(errorMessage).css('color', 'red');
                }
            });
        }

        // Event listener for category name input
        $('#tag_name').on('input', debounce(function () {
            var categoryName = $(this).val();
            var slug = generateSlug(categoryName);
            $('#tag_slug').val(slug);

            // Check slug availability
            checkTagSlug(categoryName);
        }, 500)); // Adjust the debounce delay as needed (500ms is a good starting point)


        $("#tags_edit").validate({
            // Specify validation rules for each input field
            rules: {
                name: {
                    required: true,
                },
                slug: {
                    required: true,
                },
                tag_content: {
                    required: true,
                },
                published: {
                    required: true,
                },
                "page_url[]": {
                    required: true,
                },

            },
            // Specify error messages for each rule
            messages: {
                name: {
                    required: "Please Enter Your Tag Name",
                },
                slug: {
                    required: "Please Enter Your Tag Slug",
                },
                tag_content: {
                    required: "Please Enter Your Related Searches Tag Content",
                },
                "page_url[]": {
                    required: "Please enter at least one Related Searches Pages",
                },
                published: {
                    required: "Please Enter Your published",
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/tagsUpdate.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr);
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }

    //post
    if (window.location.pathname == '/admin/post/add') {
        // Function to populate categories into the dropdown
        function populateCategories(categories) {
            var dropdown = $('#post_category_dropdown');
            dropdown.empty(); // Clear existing options

            categories.forEach(function (category) {
                var option = $('<option></option>')
                    .attr('value', category.id)
                    .text(category.name);
                dropdown.append(option);
            });

            // Refresh the Bootstrap Select plugin after updating options
            dropdown.selectpicker('refresh');
        }

        // AJAX call to get categories on page load
        $.ajax({
            type: 'GET',
            url: '/admin/service/getCategories.php',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    console.log(response.categories);
                    populateCategories(response.categories);
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function (xhr, status, error) {
                var errorMessage = 'Error: ' + xhr.status + ' - ' + xhr.statusText + '\n' + xhr.responseText;
                toastr.error(errorMessage, 'Error');
            }
        });

        // post_tag_dropdown
        // Function to populate tags
        function populateTags(tags) {
            var tagDropdown = $('#post_tag_dropdown');
            tagDropdown.empty(); // Clear existing options

            // // Add default option
            // tagDropdown.append('<option>Select Tag(s)</option>');

            // Add tags dynamically
            $.each(tags, function (index, tag) {
                var option = $('<option></option>')
                    .attr('value', tag.id)
                    .text(tag.name);
                tagDropdown.append(option);
            });

            // Refresh Bootstrap Select picker
            tagDropdown.selectpicker('refresh');
        }
        // Fetch tags using AJAX on page load
        $.ajax({
            url: '/admin/service/getTags.php', // Adjust the URL to your backend script
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                populateTags(response); // Call function to populate tags
            },
            error: function (xhr, status, error) {
                console.error('Error fetching tags:', error);
            }
        });
        // Initialize Bootstrap Select picker
        $('#post_tag_dropdown').selectpicker();

        // Function to check slug availability
        function checkPostSlug(slug) {
            $.ajax({
                type: 'POST',
                url: '/admin/service/checkPostsSlug.php',
                data: { slug: slug },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function (xhr, status, error) {
                    var errorMessage = 'Error: ' + xhr.status + ' - ' + xhr.statusText + '\n' + xhr.responseText;
                    $('#slug_message').text(errorMessage).css('color', 'red');
                }
            });
        }

        // Event listener for category name input
        $('#post_name').on('input', debounce(function () {
            var categoryName = $(this).val();
            var slug = generateSlug(categoryName);
            $('#post_slug').val(slug);

            // Check slug availability
            checkPostSlug(slug);
        }, 500)); // Adjust the debounce delay as needed (500ms is a good starting point)


        $("#posts_add").validate({
            // Specify validation rules for each input field
            rules: {
                title: {
                    required: true,
                },
                slug: {
                    required: true,
                },
                meta_title: {
                    required: true,
                },
                meta_descriptions: {
                    required: true,
                },
                meta_keyword: {
                    required: true,
                },
                featured_image_alt: {
                    required: true,
                },
                featured_image: {
                    required: true,
                },
                image: {
                    required: true,
                },
                image_alt: {
                    required: true,
                },
                published: {
                    required: true,
                },
                category_id: {
                    required: true,
                },
                "tag_id[]": {
                    required: true,
                },
                content: {
                    required: true,
                },

            },
            // Specify error messages for each rule
            messages: {
                name: {
                    required: "Please Enter Your Tag Name",
                },
                slug: {
                    required: "Please Enter Your Tag Slug",
                },
                tag_content: {
                    required: "Please Enter Your Related Searches Tag Content",
                },
                "page_url[]": {
                    required: "Please enter at least one Related Searches Pages",
                },
                published: {
                    required: "Please Enter Your published",
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);


                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/postsStore.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }
    if (window.location.pathname.startsWith('/admin/post/edit')) {
        // Function to populate categories into the dropdown
        function populateCategories(categories) {
            var dropdown = $('#post_category_dropdown');
            dropdown.empty(); // Clear existing options

            categories.forEach(function (category) {
                var option = $('<option></option>')
                    .attr('value', category.id)
                    .text(category.name);
                dropdown.append(option);
            });

            // Refresh the Bootstrap Select plugin after updating options
            dropdown.selectpicker('refresh');
        }

        // AJAX call to get categories on page load
        $.ajax({
            type: 'GET',
            url: '/admin/service/getCategories.php',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    console.log(response.categories);
                    populateCategories(response.categories);
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function (xhr, status, error) {
                var errorMessage = 'Error: ' + xhr.status + ' - ' + xhr.statusText + '\n' + xhr.responseText;
                toastr.error(errorMessage, 'Error');
            }
        });


        // Function to check slug availability
        function checkPostSlug(slug) {
            $.ajax({
                type: 'POST',
                url: '/admin/service/checkPostsSlug.php',
                data: { slug: slug },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function (xhr, status, error) {
                    var errorMessage = 'Error: ' + xhr.status + ' - ' + xhr.statusText + '\n' + xhr.responseText;
                    $('#slug_message').text(errorMessage).css('color', 'red');
                }
            });
        }

        // Event listener for category name input
        $('#post_name').on('input', debounce(function () {
            var categoryName = $(this).val();
            var slug = generateSlug(categoryName);
            $('#post_slug').val(slug);

            // Check slug availability
            checkPostSlug(slug);
        }, 500)); // Adjust the debounce delay as needed (500ms is a good starting point)

        // Function to fetch content based on ID
        function fetchContent(id) {
            $.ajax({
                url: '/admin/service/postsFindbyid.php', // Change to your PHP script URL
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    console.log('Response:', response);
                    if (response) {
                        $("input[name='id']").val(response.id);
                        $("input[name='title']").val(response.title);
                        $("input[name='slug']").val(response.slug);
                        $("input[name='meta_title']").val(response.meta_title);
                        $("input[name='meta_descriptions']").val(response.meta_descriptions);
                        $("input[name='meta_keyword']").val(response.meta_keyword);
                        $("input[name='featured_image_alt']").val(response.featured_image_alt);
                        $("input[name='image_alt']").val(response.image_alt);
                        $("#imagePreview").attr("src", response.featured_image);
                        $("#img-preview").attr("src", response.image);
                        // Set the HTML content into Summernote
                        $('#summernote').summernote('code', htmlSpecialCharsDecode(response.content));

                        setSelectValues("tag_id[]", response.tags);
                        setSelectValue("category_id", response.category_id);
                        setSelectValue("published", response.published);
                    } else {
                        console.error('Response is empty or invalid');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching content:', error);
                }
            });
        }

        // Function to set select values for multiple selection
        function setSelectValues(name, values) {
            var select = $("select[name='" + name + "']");
            select.val(null); // Clear existing selection

            values.forEach(function (value) {
                // Check if option already exists in select
                if (!select.find("option[value='" + value.id + "']").length) {
                    // Create new option element
                    var option = new Option(value.name, value.id);

                    // Set 'selected' attribute if specified
                    if (value.selected === 'selected') {
                        $(option).attr('selected', 'selected');
                    }

                    // Append the option to the select element
                    select.append(option);
                }
            });

            // Refresh the Bootstrap Select plugin after updating options
            select.selectpicker('refresh');

            // Trigger change event to reflect updated selection
            select.trigger('change');
        }

        // Function to set a single select value
        function setSelectValue(name, value) {
            var select = $("select[name='" + name + "']");
            if (select.find("option[value='" + value + "']").length) {
                select.val(value);
            } else {
                select.append(new Option(value, value, true, true));
                select.val(value);
            }
            select.trigger('change');
        }


        // Example: Fetch content when the page loads
        var id = getUrlParameter('id'); // Assuming you have a function to get URL parameters
        if (id) {
            fetchContent(id);
        }

        // Function to get URL parameter by name
        function getUrlParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        $("#posts_edit").validate({
            // Specify validation rules for each input field
            rules: {
                title: {
                    required: true,
                },
                slug: {
                    required: true,
                },
                meta_title: {
                    required: true,
                },
                meta_descriptions: {
                    required: true,
                },
                meta_keyword: {
                    required: true,
                },
                featured_image_alt: {
                    required: true,
                },
                image_alt: {
                    required: true,
                },
                published: {
                    required: true,
                },
                category_id: {
                    required: true,
                },
                "tag_id[]": {
                    required: true,
                },
                content: {
                    required: true,
                },

            },
            // Specify error messages for each rule
            messages: {
                name: {
                    required: "Please Enter Your Tag Name",
                },
                slug: {
                    required: "Please Enter Your Tag Slug",
                },
                tag_content: {
                    required: "Please Enter Your Related Searches Tag Content",
                },
                "page_url[]": {
                    required: "Please enter at least one Related Searches Pages",
                },
                published: {
                    required: "Please Enter Your published",
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/postsUpdate.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }
    // users
    if (window.location.pathname == '/admin/users/add') {
        $("#user_add_form").validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                role_id: {
                    required: true,
                },
                password: {
                    required: true,
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
            },
            messages: {
                name: {
                    required: "Please enter your name",
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                role_id: {
                    required: "Please select a role",
                },
                password: {
                    required: "Please enter your password",
                },
                password_confirmation: {
                    required: "Please confirm your password",
                    equalTo: "Passwords do not match"
                },
            },
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                var formData = new FormData($(form)[0]);

                $.ajax({
                    type: "POST",
                    url: "/admin/service/usersStore.php", // Change the URL to the correct endpoint
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            }
        });
    }
    if (window.location.pathname.startsWith('/admin/users/edit')) {

        // Function to fetch content based on ID
        function fetchContent(id) {
            $.ajax({
                url: '/admin/service/usersFindbyid.php', // Change to your PHP script URL
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    console.log('Response:', response);
                    if (response) {
                        $("input[name='id']").val(response.id);
                        $("input[name='name']").val(response.name);
                        $("input[name='email']").val(response.email);
                        setSelectValue("role_id", response.role_id);
                        setSelectValue("published", response.published);
                    } else {
                        console.error('Response is empty or invalid');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching content:', error);
                }
            });
        }

        // Function to set a single select value
        function setSelectValue(name, value) {
            var select = $("select[name='" + name + "']");
            if (select.find("option[value='" + value + "']").length) {
                select.val(value);
            } else {
                select.append(new Option(value, value, true, true));
                select.val(value);
            }
            select.trigger('change');
        }


        // Example: Fetch content when the page loads
        var id = getUrlParameter('id'); // Assuming you have a function to get URL parameters
        if (id) {
            fetchContent(id);
        }

        // Function to get URL parameter by name
        function getUrlParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        $("#user_edit_form").validate({
            // Specify validation rules for each input field
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                role_id: {
                    required: true,
                },
                password: {
                    required: true,
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },

            },
            // Specify error messages for each rule
            messages: {
                name: {
                    required: "Please enter your name",
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                role_id: {
                    required: "Please select a role",
                }
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/usersUpdate.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }
    // clients

    if (window.location.pathname == '/admin/website/clients/add') {
        $("#clients_add").validate({
            rules: {
                name: {
                    required: true,
                },
                image: {
                    required: true,
                },
                image_alt: {
                    required: true,
                },
                published: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                },
                image: {
                    required: "Please enter your image",
                },
                image_alt: {
                    required: "Please enter your image_alt",
                },
                published: {
                    required: "Please enter your published",
                },

            },
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                var formData = new FormData($(form)[0]);

                $.ajax({
                    type: "POST",
                    url: "/admin/service/website_req_clientsStore.php", // Change the URL to the correct endpoint
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            }
        });
    }
    if (window.location.pathname.startsWith('/admin/website/clients/edit')) {

        // Function to fetch content based on ID
        function fetchContent(id) {
            $.ajax({
                url: '/admin/service/website_req_clientsFindbyid.php', // Change to your PHP script URL
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    console.log('Response:', response);
                    if (response) {
                        $("input[name='id']").val(response.id);
                        $("input[name='name']").val(response.name);
                        $("input[name='image_alt']").val(response.image_alt);
                        $("input[name='Thumbnail_Image_available']").val(response.image);
                        setSelectValue("published", response.published);
                    } else {
                        console.error('Response is empty or invalid');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching content:', error);
                }
            });
        }

        // Function to set a single select value
        function setSelectValue(name, value) {
            var select = $("select[name='" + name + "']");
            if (select.find("option[value='" + value + "']").length) {
                select.val(value);
            } else {
                select.append(new Option(value, value, true, true));
                select.val(value);
            }
            select.trigger('change');
        }


        // Example: Fetch content when the page loads
        var id = getUrlParameter('id'); // Assuming you have a function to get URL parameters
        if (id) {
            fetchContent(id);
        }

        // Function to get URL parameter by name
        function getUrlParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        $("#clients_edit").validate({
            rules: {
                name: {
                    required: true,
                },
                image_alt: {
                    required: true,
                },
                published: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                },
                image_alt: {
                    required: "Please enter your image_alt",
                },
                published: {
                    required: "Please enter your published",
                },

            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/website_req_clientsUpdate.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr);
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }
    // Portfolio
    if (window.location.pathname == '/admin/website/portfolio/add') {
        $("#portfolio_add").validate({
            rules: {
                name: {
                    required: true,
                },
                image: {
                    required: true,
                },
                image_alt: {
                    required: true,
                },
                published: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                },
                image: {
                    required: "Please enter your image",
                },
                image_alt: {
                    required: "Please enter your image_alt",
                },
                published: {
                    required: "Please enter your published",
                },

            },
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                var formData = new FormData($(form)[0]);

                $.ajax({
                    type: "POST",
                    url: "/admin/service/website_req_portfolioStore.php", // Change the URL to the correct endpoint
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            }
        });
    }
    if (window.location.pathname.startsWith('/admin/website/portfolio/edit')) {

        // Function to fetch content based on ID
        function fetchContent(id) {
            $.ajax({
                url: '/admin/service/website_req_portfolioFindbyid.php', // Change to your PHP script URL
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    console.log('Response:', response);
                    if (response) {
                        $("input[name='id']").val(response.id);
                        $("input[name='name']").val(response.name);
                        $("input[name='image_alt']").val(response.image_alt);
                        $("input[name='Thumbnail_Image_available']").val(response.image);
                        setSelectValue("published", response.published);
                    } else {
                        console.error('Response is empty or invalid');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching content:', error);
                }
            });
        }

        // Function to set a single select value
        function setSelectValue(name, value) {
            var select = $("select[name='" + name + "']");
            if (select.find("option[value='" + value + "']").length) {
                select.val(value);
            } else {
                select.append(new Option(value, value, true, true));
                select.val(value);
            }
            select.trigger('change');
        }


        // Example: Fetch content when the page loads
        var id = getUrlParameter('id'); // Assuming you have a function to get URL parameters
        if (id) {
            fetchContent(id);
        }

        // Function to get URL parameter by name
        function getUrlParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        $("#portfolio_edit").validate({
            rules: {
                name: {
                    required: true,
                },
                image_alt: {
                    required: true,
                },
                published: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                },
                image_alt: {
                    required: "Please enter your image_alt",
                },
                published: {
                    required: "Please enter your published",
                },

            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/website_req_portfolioUpdate.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr);
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }

    // testimonial

    if (window.location.pathname == '/admin/website/testimonial/add') {
        $("#testimonial_add").validate({
            rules: {
                name: {
                    required: true,
                },
                comment: {
                    required: true,
                },
                image: {
                    required: true,
                },
                image_alt: {
                    required: true,
                },
                published: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                },
                comment: {
                    required: "Please enter your comment",
                },
                image: {
                    required: "Please enter your image",
                },
                image_alt: {
                    required: "Please enter your image_alt",
                },
                published: {
                    required: "Please enter your published",
                },

            },
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                var formData = new FormData($(form)[0]);

                $.ajax({
                    type: "POST",
                    url: "/admin/service/website_req_testimonialStore.php", // Change the URL to the correct endpoint
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr);
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            }
        });
    }
    if (window.location.pathname.startsWith('/admin/website/testimonial/edit')) {

        // Function to fetch content based on ID
        function fetchContent(id) {
            $.ajax({
                url: '/admin/service/website_req_testimonialFindbyid.php', // Change to your PHP script URL
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    console.log('Response:', response);
                    if (response) {
                        $("input[name='id']").val(response.id);
                        $("input[name='name']").val(response.name);
                        $("textarea[name='comment']").val(response.comment);
                        $("input[name='image_alt']").val(response.image_alt);
                        $("input[name='Thumbnail_Image_available']").val(response.image);
                        setSelectValue("published", response.published);
                    } else {
                        console.error('Response is empty or invalid');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching content:', error);
                }
            });
        }

        // Function to set a single select value
        function setSelectValue(name, value) {
            var select = $("select[name='" + name + "']");
            if (select.find("option[value='" + value + "']").length) {
                select.val(value);
            } else {
                select.append(new Option(value, value, true, true));
                select.val(value);
            }
            select.trigger('change');
        }


        // Example: Fetch content when the page loads
        var id = getUrlParameter('id'); // Assuming you have a function to get URL parameters
        if (id) {
            fetchContent(id);
        }

        // Function to get URL parameter by name
        function getUrlParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        $("#testimonial_edit").validate({
            rules: {
                name: {
                    required: true,
                },
                comment: {
                    required: true,
                },
                image_alt: {
                    required: true,
                },
                published: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                },
                comment: {
                    required: "Please enter your comment",
                },
                image_alt: {
                    required: "Please enter your image_alt",
                },
                published: {
                    required: "Please enter your published",
                },

            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/website_req_testimonialUpdate.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr);
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }

    // companies
    if (window.location.pathname == '/admin/website/companies/add') {
        $("#companies_add").validate({
            rules: {
                name: {
                    required: true,
                },
                page_url: {
                    required: true,
                },
                published: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                },
                page_url: {
                    required: "Please enter your Page url",
                },
                published: {
                    required: "Please enter your published",
                },

            },
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                var formData = new FormData($(form)[0]);

                $.ajax({
                    type: "POST",
                    url: "/admin/service/website_req_companiesStore.php", // Change the URL to the correct endpoint
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr);
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            }
        });
    }
    if (window.location.pathname.startsWith('/admin/website/companies/edit')) {

        // Function to fetch content based on ID
        function fetchContent(id) {
            $.ajax({
                url: '/admin/service/website_req_companiesFindbyid.php', // Change to your PHP script URL
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    console.log('Response:', response);
                    if (response) {
                        $("input[name='id']").val(response.id);
                        $("input[name='name']").val(response.name);
                        $("input[name='page_url']").val(response.page_url);
                        setSelectValue("published", response.published);
                    } else {
                        console.error('Response is empty or invalid');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching content:', error);
                }
            });
        }

        // Function to set a single select value
        function setSelectValue(name, value) {
            var select = $("select[name='" + name + "']");
            if (select.find("option[value='" + value + "']").length) {
                select.val(value);
            } else {
                select.append(new Option(value, value, true, true));
                select.val(value);
            }
            select.trigger('change');
        }


        // Example: Fetch content when the page loads
        var id = getUrlParameter('id'); // Assuming you have a function to get URL parameters
        if (id) {
            fetchContent(id);
        }

        // Function to get URL parameter by name
        function getUrlParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        $("#companies_edit").validate({
            rules: {
                name: {
                    required: true,
                },
                page_url: {
                    required: true,
                },
                published: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                },
                page_url: {
                    required: "Please enter your Page url",
                },
                published: {
                    required: "Please enter your published",
                },

            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/website_req_companiesUpdate.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr);
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }

    $("#logout").click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/admin/service/logout.php", // Specify the URL to send the data
            contentType: false, // Set to false to let jQuery handle the content type
            processData: false, // Prevent jQuery from processing the data
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.success) {
                    window.location.href = response.message;
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                toastr.error(errorMessage, 'Error');
            },
        });
    });

    // dashboard
    if (window.location.pathname == '/admin/' || window.location.pathname == '/admin') {
        $.ajax({
            url: '/admin/service/count.php', // Replace with the correct URL to your PHP script
            type: 'GET',
            data: { id: id }, // Assuming you are passing an 'id' parameter
            dataType: 'json',
            success: function (response) {
                console.log(response.counts);
                if (response) {
                    // Update each count based on the response
                    $(".number.count-to").each(function (index) {
                        switch (index) {
                            case 0:
                                var countValue = response.counts["posts_count"];
                                $(this).countTo({ from: 0, to: countValue });
                                break;
                            case 1:
                                var countValue = response.counts["clients_count"];
                                $(this).countTo({ from: 0, to: countValue });
                                break;
                            case 2:
                                var countValue = response.counts["testimonial_count"];
                                $(this).countTo({ from: 0, to: countValue });
                                break;
                            case 3:
                                var countValue = response.counts["users_count"];
                                $(this).countTo({ from: 0, to: countValue });
                                break;
                            default:
                                break;
                        }
                    });
                } else {
                    toastr.error('Error fetching counts.', 'Error');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching content:', error);
                toastr.error('Error fetching counts.', 'Error');
            }
        });
        // recentposts.php 
        $.ajax({
            url: '/admin/service/recentposts.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    response.recent_posts.forEach((post, index) => {
                        $("#recentposts").append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${formatDate(post.created_at)}</td>
                                <td>
                                 <a href="/latest-news-blog-updates/details/${post.slug}" target="_blank" rel="noopener noreferrer">
                                ${post.title}
                                </a>
                                </td>
                                <td>
                                    <div class="inbox-img">
                                    <a href="${post.image}" data-lightbox="image-${index + 1}">
                                    <img src="${post.image}" class="rounded" alt="${post.image_alt}" style="height: 39px;">
                                    </a>
                                    </div>
                                </td>
                                <td>${post.category_name}</td>
                                <td>${post.user_name}</td>
                            </tr>
                        `);
                    });
                } else {
                    toastr.error('Error fetching recent posts.', 'Error');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching content:', error);
                toastr.error('Error fetching recent posts.', 'Error');
            }
        });
        // recentContact
        $.ajax({
            url: '/admin/service/recentContact.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    response.lead_contacts.forEach((contact, index) => {
                        $("#recentContact").append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${formatDate(contact.created_at)}</td>
                                <td>${contact.name}</td>
                                <td>${contact.email}</td>
                                <td>${contact.phone}</td>
                                <td>${contact.subject}</td>
                                <td>${contact.message}</td>
                            </tr>
                        `);
                    });
                } else {
                    toastr.error('Error fetching recent posts.', 'Error');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching content:', error);
                toastr.error('Error fetching recent posts.', 'Error');
            }
        });



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


    }

    // related_searches_add
    if (window.location.pathname == '/admin/website/related-searches/add') {

        $("#related_searches_add").validate({
            // Specify validation rules for each input field
            rules: {
                name: {
                    required: true,
                },
                tag_content: {
                    required: true,
                },
                published: {
                    required: true,
                },
                "page_url[]": {
                    required: true,
                },

            },
            // Specify error messages for each rule
            messages: {
                name: {
                    required: "Please Enter Your Tag Name",
                },
                tag_content: {
                    required: "Please Enter Your Related Searches Tag Content",
                },
                "page_url[]": {
                    required: "Please enter at least one Related Searches Pages",
                },
                published: {
                    required: "Please Enter Your published",
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/related_searchesStore.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }
    if (window.location.pathname.startsWith('/admin/website/related-searches/edit')) {

        // Function to fetch content based on ID
        function fetchContent(id) {
            $.ajax({
                url: '/admin/service/related_searchesFindbyid.php', // Change to your PHP script URL
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    console.log('Response:', response);
                    if (response) {
                        $("input[name='id']").val(response.id);
                        $("input[name='name']").val(response.name);
                        // $("textarea[name='tag_content']").val(response.tag_content);
                        $('#summernote').summernote('code', htmlSpecialCharsDecode(response.tag_content));
                        setSelectValues("page_url[]", JSON.parse(response.page_url));
                        setSelectValue("published", response.published);
                    } else {
                        console.error('Response is empty or invalid');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching content:', error);
                }
            });
        }

        // Function to set select values for multiple selection
        function setSelectValues(name, values) {
            var select = $("select[name='" + name + "']");
            select.val(null); // Clear existing selection
            values.forEach(function (value) {
                if (select.find("option[value='" + value + "']").length) {
                    select.find("option[value='" + value + "']").prop("selected", true);
                } else {
                    select.append(new Option(value, value, true, true));
                }
            });
            select.trigger('change');
        }

        // Function to set a single select value
        function setSelectValue(name, value) {
            var select = $("select[name='" + name + "']");
            if (select.find("option[value='" + value + "']").length) {
                select.val(value);
            } else {
                select.append(new Option(value, value, true, true));
                select.val(value);
            }
            select.trigger('change');
        }


        // Example: Fetch content when the page loads
        var id = getUrlParameter('id'); // Assuming you have a function to get URL parameters
        if (id) {
            fetchContent(id);
        }

        // Function to get URL parameter by name
        function getUrlParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        $("#related_searches_edit").validate({
            // Specify validation rules for each input field
            rules: {
                name: {
                    required: true,
                },
                tag_content: {
                    required: true,
                },
                published: {
                    required: true,
                },
                "page_url[]": {
                    required: true,
                },

            },
            // Specify error messages for each rule
            messages: {
                name: {
                    required: "Please Enter Your Tag Name",
                },
                tag_content: {
                    required: "Please Enter Your Related Searches Tag Content",
                },
                "page_url[]": {
                    required: "Please enter at least one Related Searches Pages",
                },
                published: {
                    required: "Please Enter Your published",
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/related_searchesUpdate.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }

    // faq_edit
    if (window.location.pathname == '/admin/website/faq/add') {

        $("#faq_add").validate({
            // Specify validation rules for each input field
            rules: {
                name: {
                    required: true,
                },
                faq_content: {
                    required: true,
                },
                published: {
                    required: true,
                },
                "page_url[]": {
                    required: true,
                },

            },
            // Specify error messages for each rule
            messages: {
                name: {
                    required: "Please Enter Your Faq Questions",
                },
                faq_content: {
                    required: "Please Enter Your Faq Content",
                },
                "page_url[]": {
                    required: "Please Select at least one Faq Tag",
                },
                published: {
                    required: "Please Enter Your published",
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/faqStore.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }
    if (window.location.pathname.startsWith('/admin/website/faq/edit')) {

        // Function to fetch content based on ID
        function fetchContent(id) {
            $.ajax({
                url: '/admin/service/faqFindbyid.php', // Change to your PHP script URL
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    console.log('Response:', response);
                    if (response) {
                        $("input[name='id']").val(response.id);
                        $("input[name='name']").val(response.name);
                        // $("textarea[name='tag_content']").val(response.tag_content);
                        $('#summernote').summernote('code', htmlSpecialCharsDecode(response.faq_content));
                        setSelectValues("page_url[]", JSON.parse(response.page_url));
                        setSelectValue("published", response.published);
                    } else {
                        console.error('Response is empty or invalid');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching content:', error);
                }
            });
        }

        // Function to set select values for multiple selection
        function setSelectValues(name, values) {
            var select = $("select[name='" + name + "']");
            select.val(null); // Clear existing selection
            values.forEach(function (value) {
                if (select.find("option[value='" + value + "']").length) {
                    select.find("option[value='" + value + "']").prop("selected", true);
                } else {
                    select.append(new Option(value, value, true, true));
                }
            });
            select.trigger('change');
        }

        // Function to set a single select value
        function setSelectValue(name, value) {
            var select = $("select[name='" + name + "']");
            if (select.find("option[value='" + value + "']").length) {
                select.val(value);
            } else {
                select.append(new Option(value, value, true, true));
                select.val(value);
            }
            select.trigger('change');
        }


        // Example: Fetch content when the page loads
        var id = getUrlParameter('id'); // Assuming you have a function to get URL parameters
        if (id) {
            fetchContent(id);
        }

        // Function to get URL parameter by name
        function getUrlParameter(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        $("#faq_edit").validate({
            // Specify validation rules for each input field
            rules: {
                name: {
                    required: true,
                },
                faq_content: {
                    required: true,
                },
                published: {
                    required: true,
                },
                "page_url[]": {
                    required: true,
                },

            },
            // Specify error messages for each rule
            messages: {
                name: {
                    required: "Please Enter Your Faq Questions",
                },
                faq_content: {
                    required: "Please Enter Your Faq Content",
                },
                "page_url[]": {
                    required: "Please Select at least one Faq Tag",
                },
                published: {
                    required: "Please Enter Your published",
                },
            },
            // Handle form submission
            submitHandler: function (form) {
                $("page-loader-wrapper").show();
                // Create FormData object
                var formData = new FormData($(form)[0]);

                // Send an Ajax request
                $.ajax({
                    type: "POST",
                    url: "/admin/service/faqUpdate.php", // Specify the URL to send the data
                    data: formData,
                    contentType: false, // Set to false to let jQuery handle the content type
                    processData: false, // Prevent jQuery from processing the data
                    dataType: "json",
                    success: function (response) {
                        $("page-loader-wrapper").hide();
                        if (response.success) {
                            window.location.href = response.message;
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function (xhr, status, error) {
                        const errorMessage = `Error: ${xhr.status} - ${xhr.statusText}\n${JSON.stringify(xhr.responseJSON)}`;
                        toastr.error(errorMessage, 'Error');
                    },
                });
            },
        });
    }

    function htmlSpecialCharsDecode(str) {
        if (typeof str !== "string") {
            return str;
        }
        const textarea = document.createElement('textarea');
        textarea.innerHTML = str;
        return textarea.value;
    }




});
<!-- Jquery Core Js -->
<script src="/admin/assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<script src="/admin/assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->

<!-- Jquery DataTable Plugin Js -->
<script src="/admin/assets/bundles/datatablescripts.bundle.js"></script>
<script src="/admin/assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="/admin/assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="/admin/assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="/admin/assets/plugins/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="/admin/assets/plugins/jquery-datatable/buttons/buttons.print.min.js"></script>

<script src="/admin/assets/bundles/jvectormap.bundle.js"></script> <!-- JVectorMap Plugin Js -->
<script src="/admin/assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js"></script><!-- USA Map Js -->
<script src="/admin/assets/bundles/sparkline.bundle.js"></script> <!-- sparkline Js -->
<script src="/admin/assets/bundles/morrisscripts.bundle.js"></script><!-- Morris Plugin Js -->

<script src="/admin/assets/plugins/dropzone/dropzone.js"></script> <!-- Dropzone Plugin Js -->

<script src="/admin/assets/plugins/ckeditor/ckeditor.js"></script> <!-- Ckeditor -->
<script src="/admin/assets/plugins/ckeditor/lang/en.js"></script> <!-- Ckeditor -->
<script src="/admin/assets/plugins/ckeditor/style.js"></script> <!-- Ckeditor -->

<script src="/admin/assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->
<script src="/admin/assets/js/pages/tables/jquery-datatable.js"></script>
<script src="/admin/assets/js/pages/blog/blog.js"></script>
<script src="/admin/assets/js/pages/jqtable/index.js"></script>
<script src="/admin/assets/js/pages/forms/editors.js"></script>
<script src="/admin/assets/js/tableresponsive.js"></script>
<script src="/admin/assets/plugins/summernote/dist/summernote.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>
<script src="/admin/assets/js/ajax/jquery.validate.min.js"></script>
<script src="/admin/assets/js/ajax/index.js"></script>
<script>
    jQuery(document).ready(function() {

        // $('#summernote').summernote({
        //     height: 350, // set editor height
        //     minHeight: null, // set minimum height of editor
        //     maxHeight: null, // set maximum height of editor
        //     focus: false, // set focus to editable area after initializing summernote
        //     popover: {
        //         image: [],
        //         link: [],
        //         air: []
        //     },
        //     // name: 'content'
        // });

        // // $('.inline-editor').summernote({
        // //     airMode: true
        // // });

        $('#summernote').summernote({
        height: 300,
        minHeight: null,
        maxHeight: null,
        focus: true,
        toolbar: [
            // Add custom toolbar options
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']], // Add font size dropdown
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['picture', 'link', 'video', 'table', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });


    });

    // window.edit = function() {
    //         $(".click2edit").summernote()
    //     },
    //     window.save = function() {
    //         $(".click2edit").summernote('destroy');
    //     }
</script>
<script>
    // Check if there's a stored scroll position
    const savedScrollPosition = sessionStorage.getItem('scrollPosition');

    // Set the scroll position if available
    if (savedScrollPosition) {
        document.querySelector('.mainNav').scrollTop = savedScrollPosition;
    }

    // Add scroll event listener to update scroll position in storage
    document.querySelector('.mainNav').addEventListener('scroll', function() {
        const scrollPosition = this.scrollTop;
        sessionStorage.setItem('scrollPosition', scrollPosition);
    });
</script>
<script>
    function logAction(actionDescription) {
        return $.ajax({
            type: "POST",
            url: "/admin/service/log_action.php",
            data: JSON.stringify({
                description: actionDescription
            }),
            contentType: "application/json",
            dataType: "json"
        });
    }

    function logAndNavigate(event, url, message, blank) {
        event.preventDefault(); // Prevent the default action

        logAction(message).done(function(e) {
            if (blank) {
                window.open(url, "_blank")
            } else {
                window.location.href = url; // Navigate to the new page after logging is complete
            }
        }).fail(function(e) {
            if (blank) {
                window.open(url, "_blank")
            } else {
                window.location.href = url; // Navigate to the new page after logging is complete
            }
        });
    }
</script>



</body>

</html>
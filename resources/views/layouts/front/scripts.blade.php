<!-- ============================================================== -->
<!-- All SCRIPTS AND JS LINKS BELOW  -->
<!-- ============================================================== -->

<!-- Js Files Start -->
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('new/js/modernizr-3.6.0.min.js') }}"></script>
<script src="{{ asset('new/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('new/js/jquery-migrate-3.3.0.min.js') }}"></script>
<script src="{{ asset('new/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('new/js/slick.js') }}"></script>
<script src="{{ asset('new/js/jquery.syotimer.min.js') }}"></script>
<script src="{{ asset('new/js/wow.js') }}"></script>
<script src="{{ asset('new/js/svg-inject.min.js') }}"></script>
<script src="{{ asset('new/js/jquery-ui.js') }}"></script>
<script src="{{ asset('new/js/jquery-ui-touch-punch.js') }}"></script>
<script src="{{ asset('new/js/magnific-popup.js') }}"></script>
<script src="{{ asset('new/js/select2.min.js') }}"></script>
<script src="{{ asset('new/js/clipboard.js') }}"></script>
<script src="{{ asset('new/js/vivus.js') }}"></script>
<script src="{{ asset('new/js/waypoints.js') }}"></script>
<script src="{{ asset('new/js/counterup.js') }}"></script>
<script src="{{ asset('new/js/mouse-parallax.js') }}"></script>
<script src="{{ asset('new/js/images-loaded.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('new/js/scrollup.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('new/js/main.js') }}"></script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>



<script type="text/javascript">
    function openNavR() {
        document.getElementById("mySidenavR").style.width = "100%";
    }

    function closeNavR() {
        document.getElementById("mySidenavR").style.width = "0";
    }
</script>
<!-- Front Scripts -->


<script>
    function editableContent() {
        $('.editable').each(function() {
            $(this).append(
                '<div class="editable-wrapper"><a href="javascript:" class="edit" title="Edit" onclick="editContent(this)"><i class="far fa-edit"></i></a><a href="javascript:" class="update" title="Update" onclick="updateContent(this)"><i class="far fa-share-square"></i></a></div>'
                );
        });
    }

    function editContent(a) {
        $(a).closest('.editable').attr('contenteditable', true);;
        $(a).closest('.editable-wrapper').attr('contenteditable', false);
        $(a).closest('.editable').focus();
    }

    function updateContent(a) {
        var editableDiv = $(a).closest('.editable');
        var id = $(editableDiv).attr('data-id');
        var keyword = $(editableDiv).attr('data-name');
        var htmlcontent = $(editableDiv).clone(true);
        $(htmlcontent).find('.editable-wrapper').remove();
        sendData(id, keyword, $(htmlcontent).html());
    }

    function sendData(id, keyword, htmlContent) {
        console.log(id);
        console.log(keyword);
        console.log(htmlContent);
        $.ajax({
            url: "update-content",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id,
                keyword: keyword,
                htmlContent: htmlContent,
            },
            success: function(response) {
                if (response.status) {
                    toastr.success(response.message);
                } else {
                    toastr.success(response.error);
                }
            },
        });
    }
</script>

<script type="text/javascript">
    $('#newForm').on('submit', function(e) {
        $('#newsresult').html('');
        e.preventDefault();

        let email = $('#newemail').val();

        $.ajax({
            url: "newsletter-submit",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                newsletter_email: email
            },
            success: function(response) {
                if (response.status) {
                  toastr.success(response.message)
                } else {
                                 toastr.error(response.message)

                }
            },
        });
    });
</script>


<script type="text/javascript">
    var ship = 0;
    $('#aboutform').on('submit', function(e) {
            //alert('hogaya');
            $('#aboutformresult').html('');
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('aboutUsSubmit') }}",
                _token: "{{ csrf_token()}}",
                type: "POST",
                data: $("#aboutform").serialize(),

                success: function(response) {
                    if (response.status) {
                        document.getElementById("aboutform").reset();
                                        toastr.success(response.message)
    ;
                    } else {
                                    toastr.error(response.message)

                    }
                    
                },
            });
        });

    $('#contactform').on('submit', function(e) {
        //alert('hogaya');
        $('#payonlinebutn').hide();
        $('#loader').show();
        $('#contactformsresult').html('');
        e.preventDefault();

        $.ajax({
            url: "{{ route('contactUsSubmit') }}",
            type: "POST",
            data: $("#contactform").serialize(),

            success: function(response) {
                if (response.status) {
                    document.getElementById("contactform").reset();
                                    toastr.success(response.message)
                                    $('#loader').hide();

                                    $('#payonlinebutn').show();

                } else {
                                   toastr.error(response.message)
                                   $('#loader').hide();

                                    $('#payonlinebutn').show();

                }
                
            },
        });
    });
    
    
    
    $('#querysubmit').on('submit',function(e){
  //alert('hogaya');
      $('#querysubmitresult').html('');
        e.preventDefault();
    
        $.ajax({
          url: "{{ route('querysubmit')}}",
          type:"POST",
          data: $("#querysubmit").serialize(),
    
          success:function(response){
            if(response.status){
              document.getElementById("querysubmit").reset();
              $('#querysubmitresult').html("<div class='alert alert-success'>" + response.message + "</div>");
            }
            else{
              $('#querysubmitresult').html("<div class='alert alert-danger'>" + response.message + "</div>");
            }
          },
         });
    });
    
    
    
    

    function googleTranslateElementInit() {
        new google.translate.TranslateElement({

        }, 'google_translate_element');
    }


    $('.language-dropdown li a').click(function() {

        $('.my-cart').load('.my-cart > *');
        var language = $(this).data('value');
        var language_name = $(this).text();
        $('.language-dropdown-active').text(language_name);
        var selectField = document.querySelector("#google_translate_element select");
        for (var i = 0; i < selectField.children.length; i++) {
            var option = selectField.children[i];
            if (option.value == language) {
                selectField.selectedIndex = i;
                // trigger change event afterwards to make google-lib translate this side
                selectField.dispatchEvent(new Event('change'));

            }
        }
        $('.skiptranslate').hide();

    })


</script>

@if (!Auth::guest())
    @if (Auth::user()->isAdmin())
        <script>
            editableContent();
        </script>
    @endif
@endif

@if (Session::has('message'))
    <script type="text/javascript">
        toastr.success("{{ Session::get('message') }}");
    </script>
@endif
@if (Session::has('error'))
    <script type="text/javascript">
        toastr.error("{{ Session::get('error') }}");
    </script>
@endif

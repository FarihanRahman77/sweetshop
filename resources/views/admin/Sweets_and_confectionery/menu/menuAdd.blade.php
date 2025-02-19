@extends('admin.master')
@section('title')
    {{ Session::get('companySettings')[0]['name'] }} Floor
@endsection
@section('content')
    <style type="text/css">
        h3 {
            color: #66a3ff;
        }

        #floorViewRow {
            padding: 0;
            margin: 0;
        }
        #floorViewRow li {
            background-color: rgb(223, 236, 236);
            padding: 1px 2px 1px 4px;
            margin-bottom: 2px;
            border-radius: 2px;
            list-style-type: none;
        }
        fieldset.scheduler-border {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            width: 100%;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
        }
    </style>
    <div class="content-wrapper">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3 style="float:left;"> Add Food Item </h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" id="menuForm" enctype="multipart/form-data">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Basic Information</legend>
                            <div class="row">
                                
                                    <div class="col-md-3">
                                        <label for="building"> Name  <span class="text-danger"> * </span></label>
                                        <input class="form-control input-sm" id="name" type="text" name="name"
                                        onkeyup="getfirstchar()"  placeholder="Enter Menu Name" required="">
                                        <span class="text-danger" id="nameError"></span>
                                    </div>
                                    <!-- <div class="col-md-3">
                                        <label for="building"> sorted <span class="text-danger"> * </span></label>
                                        <input class="form-control input-sm" id="firstLetter" type="text" name="firstLetter"
                                            placeholder="Enter First Letter" required="" readonly>
                                        <span class="text-danger" id="firstLetterError"></span>
                                    </div> -->
                                    <div class="col-md-3">
                                        <label for="building"> sort code <span class="text-danger"> * </span></label>
                                        <input class="form-control input-sm" id="sort_code" type="number" name="sort_code"
                                            placeholder="Enter sort code" required="" >
                                        <span class="text-danger" id="firstLetterError"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="building"> Price  <span class="text-danger"> * </span></label>
                                        <input class="form-control input-sm text-right" id="max_price" type="text" name="max_price"
                                            placeholder="Enter Menu Pprice" required="" onkeyup="max_priceValidation()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                        <span class="text-danger" id="max_priceError"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="building"> Discount (Percentage) <span class="text-danger"> * </span></label>
                                        <input class="form-control input-sm text-right" id="discount_percentage" type="text" name="discount_percentage"
                                            placeholder="Enter Discount %" required="" onkeyup="calculateMinPrice()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                        <span class="text-danger" id="discount_percentageError"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="building"> Minimum Price  <span class="text-danger"> * </span></label>
                                        <input class="form-control input-sm text-right" id="min_price" type="text" name="min_price"
                                            placeholder="Enter Menu MinimumP rice" required="" onkeyup="calculateDiscount()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                        <span class="text-danger" id="min_priceError"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="building"> Category  <span class="text-danger"> * </span></label>
                                        <select class="form-control input-sm" id="category_id" name="category_id">
                                            <option value="" selected> Select Asset Serialize Product </option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="category_idError"></span>
                                    </div>
                                    <div class=" col-md-9" id="imgDiv">
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <label for="building"> Image  <span class="text-danger"> * </span></label>
                                                <input class="img form-control input-sm" id="image" type="file" name="image[]" multiple>
                                                <span class="text-danger" id="imageError"></span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="images-preview-div row" ></div>
                                                <!-- <img id="showImage" src="{{ asset('upload/no_image.png') }}"
                                                alt="Image Not Found"
                                                style="width: 100%;height: 60px; border:1px solid #000000;margin: 2% 0% 0% 0%;"> -->
                                            </div>
                                            <!-- <div class=" col-1">
                                                <button type="button" class="btn btn-cyan btn-md add mt-4 "
                                                    onclick="addNewImg()"><span class="glyphicon glyphicon-plus"
                                                        style="font-size: 18px; font-weight:800;"><strong>+</strong></span></button>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Specification</legend>
                                <div class="row">
                                    <!-- Start spec -->
                                    <div class=" col-md-8" id="specSectionService">
                                        <div class="row">
                                            <div class=" col-6">
                                                <label> Specification</label>
                                                <input class="form-control input-sm" id="specName" type="text"
                                                    name="specName" placeholder=" Name">
                                                <span class="text-danger" id="specError"></span>
                                            </div>
                                            <div class=" col-5">
                                                <label>Value </label>
                                                <input class="form-control input-sm" id="specValue" type="text"
                                                    name="specValue" placeholder="Value">
                                                <span class="text-danger" id="specError"></span>
                                            </div>
                                            <div class=" col-1">
                                                <button type="button" class="btn btn-cyan btn-md add mt-4 "
                                                    onclick="addNewSpecRowService()"><span class="glyphicon glyphicon-plus"
                                                        style="font-size: 18px; font-weight:800;"><strong>+</strong></span></button>
                                            </div>
                                            <!--new spec append here...-->
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <label>Notes</label>
                                        <textarea class="form-control input-sm" id="notes" type="text" name="notes"
                                            placeholder=" Notes about menu... "></textarea>
                                        <span class="text-danger" id="notesError"></span>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <button type="submit" class="btn btn-cyan float-right" ><i
                                        class="fa fa-save"></i>
                                        Submit
                                    </button>
                                </div>
                            <!-- End spec -->
                            </fieldset>
                    </form>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    

    
@endsection

@section('javascript')
    <script>
        
        $(document).ready(function() {
            $('#max_price').val(0);
            $('#min_price').val(0);
            $('#discount_percentage').val(0);
        });


       
            function getfirstchar(){
                var str = $('#name').val();
                var firstLetter=str.charAt(0);
                $('#firstLetter').val(firstLetter);
            }

        $(document).ready(function() {
            $('#image').change(function(e) {
                previewImages(this, 'div.images-preview-div');
            });
            $('#edit_image').change(function(e) {
                editPreviewImages(this, 'div.edit-images-preview-div');
            });
        });

        var previewImages = function(input, imgPreviewPlaceholder) {
            $('.images-preview-div').html("");
            if (input.files) {
                var filesAmount = input.files.length;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        $($.parseHTML('<img>'))
                            .attr('src', event.target.result)
                            .css({
                                'width': '100px',  // Set image width
                                'height': '100px', // Set image height
                                'object-fit': 'cover'  // Optional: crop to fit
                            })
                            .appendTo(imgPreviewPlaceholder);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        }
        var editPreviewImages = function(input, imgPreviewPlaceholder) {
            //   $('.edit-images-preview-div').html("");
            if (input.files) {
                var filesAmount = input.files.length;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(
                            imgPreviewPlaceholder);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        }


        function max_priceValidation(){
            var max_price=$('#max_price').val();
            if(max_price == ""){
                $('#max_price').val(0);
            }
            var discount_percentage=$('#discount_percentage').val();
            if(discount_percentage == ""){
                $('#discount_percentage').val(0);
            }
            var value= (((100 - discount_percentage) / 100)* max_price);
            $('#min_price').val(value);
       }



       function calculateDiscount(){
            var max_price=$('#max_price').val();
            var min_price=$('#min_price').val();
            if(min_price == ""){
                $('#min_price').val(0);
            }
            var value= ((max_price - min_price) * 100)/ max_price;
            $('#discount_percentage').val(value);
       }


       function calculateMinPrice(){
            var max_price=$('#max_price').val();
            var discount_percentage=$('#discount_percentage').val();
            if(discount_percentage == ""){
                $('#discount_percentage').val(0);
            }
            var value= (((100 - discount_percentage) / 100)* max_price);
            $('#min_price').val(value);
       }
       


        $("#category_id").select2({
            placeholder: "Select Category",
            allowClear: true,
            width: '100%'
        });




        var rowNumber = 0;
        function addNewSpecRowService() {
            var newSpecRow = '<div class="row" id="' + rowNumber + '">' +
                '<div class=" col-6 mt-2">' +
                '<input class="form-control input-sm"  id="specName" type="text" name="specName" placeholder=" Name">' +
                '<span class="text-danger" id="specError" ></span>' +
                '</div>' +
                '<div class=" col-5 mt-2">' +
                '<input class="form-control input-sm"  id="specValue" type="text" name="specValue" placeholder=" Value">' +
                '<span class="text-danger" id="specError"></span>' +
                '</div>' +
                '<div class=" col-1 mt-2">' +
                '<button type="button" class="btn btn-danger btn-md add" onclick="deleteSpecRow(' +
                rowNumber +
                ');"><span class="glyphicon glyphicon-plus" style="font-size: 18px; font-weight:800;"><strong>x</strong></span></button>' +
                '</div></div>';
            $("#specSectionService").append(newSpecRow);
            rowNumber++;
        } // End add new spec row


        function deleteSpecRow(rowNum) {
            $('#' + rowNum).remove();
        }



        var imgRowId=1;
        function addNewImg(){
            var newImg='<div id="'+imgRowId+'" class="col-md-12 row">'+
                            '<div class="col-md-6" >'+
                                '<label for="building"> Image  <span class="text-danger"> * </span></label>'+
                                '<input class="img form-control input-sm" id="image-'+imgRowId+'" type="file" name="image[]"'+
                                    'placeholder="Enter Menu MinimumP rice" required="" onchange="previewImg('+imgRowId+')">'+
                                '<span class="text-danger" id="imageError"></span>'+
                            '</div>'+
                            '<div class="col-md-1">'+
                                '<img id="showImage-'+imgRowId+'" src="{{ asset('upload/no_image.png') }}"'+
                                'alt="Image Not Found"'+
                                'style="width: 100%;height: 60px; border:1px solid #000000;margin: 2% 0% 0% 0%;">'+
                            '</div>'+
                            '<div class=" col-1">'+
                                '<button type="button" class="btn btn-cyan btn-md add mt-4 "'+
                                    'onclick="addNewImg()"><span class="glyphicon glyphicon-plus"'+
                                        'style="font-size: 18px; font-weight:800;"><strong>+</strong></span></button>'+
                            
                                '<button type="button" class="btn btn-danger btn-md add mt-4 "'+
                                    'onclick="deleteNewImg('+imgRowId+')"><span class="glyphicon glyphicon-plus"'+
                                        'style="font-size: 18px; font-weight:800;"><strong>X</strong></span></button>'+
                            '</div>'
                        '</div>';
            $("#imgDiv").append(newImg);
            imgRowId++;
        }

        function deleteNewImg(id) {
            $('#' + id).remove();
        }



        


        function previewImg(index){
            var fileInput = document.getElementById('image-'+ index);
            var file = fileInput.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage-'+index).attr('src', e.target.result);
                var imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.style.maxWidth = '200px'; 
                imgElement.style.maxHeight = '200px'; 
                var previewContainer = document.getElementById('showImage-'+index);
                if (!previewContainer) {
                    previewContainer = document.createElement('div');
                    previewContainer.id = 'showImage-'+index;
                    fileInput.parentNode.appendChild(previewContainer);
                } else {
                    previewContainer.innerHTML = '';
                }
                previewContainer.appendChild(imgElement); 
            };
            reader.readAsDataURL(file);
        }
        

        

        $("#menuForm").submit(function(e) {
            e.preventDefault();
            var name= $('#name').val();
            var sort_code= $('#sort_code').val();
            var max_price= $('#max_price').val();
            var min_price= $('#min_price').val();
            var discount_percentage= $('#discount_percentage').val();
            var category_id= $('#category_id').val();
            // var firstLetter= $('#firstLetter').val();
            var notes= $('#notes').val();
            var specNames = $('input[id^=specName]').map(function(index, name) {
                return $(name).val();
            }).get();
            var specValues = $('input[id^=specValue]').map(function(index, value) {
                return $(value).val();
            }).get();
            var image = $("#image")[0];
            let totalFilesToBeUploaded = $('#image')[0].files.length;
            var _token = $('input[name="_token"]').val();

            var fd = new FormData();

            for (let i = 0; i < totalFilesToBeUploaded; i++) {
                fd.append('image' + i, image.files[i]);
            }
            fd.append('totalFilesToBeUploaded', totalFilesToBeUploaded);
            fd.append('name', name);
            fd.append('sort_code', sort_code);
            fd.append('max_price',max_price);
            fd.append('min_price', min_price);
            fd.append('discount_percentage', discount_percentage);
            fd.append('category_id', category_id);
            // fd.append('firstLetter', firstLetter);
            fd.append('notes', notes);
            fd.append('specNames', specNames);
            fd.append('specValues', specValues);
            fd.append('_token', _token);
            
            $.ajax({
                url: "{{ route('restaurentManagement.menu.store') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                success: function(result) {
                    //  alert(JSON.stringify(result));
                    Swal.fire("Menu Saved!", result.success, "success");
                    window.location.href = "{{url('restaurentManagement/menu/view')}}";
                },
                error: function(response) {
                //   alert(JSON.stringify(response));
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                }

            })
        })

        function clearMessages() {
            $('#nameError').text("");
            $('#buildingError').text("");
            $('#capacityError').text("");
            $('#roomError').text("");
        }

        function reset() {
            $("#name").val("");
            $("#capacity").val("");
            $("#building").val("").trigger('change');
            $("#room").val("").trigger('change');
            $("#asset_product_id").val("").trigger('change');
            $("#asset_serialize_product_id").val("").trigger('change');
        }


        function editClearMessages() {
            $("#editNameError").text("");
            $("#editCapacityError").text("");
            $("#editBuildingError").text("");
            $("#editRoomError").text("");
            $("#editAsset_product_idError").text("");
            $("#editAsset_serialize_product_idError").text("");
        }


        function editReset() {
            $("#editName").val("");
            $("#editCapacity").val("");
        }

        



        Mousetrap.bind('ctrl+shift+n', function(e) {
            e.preventDefault();
            if ($('#modal.in, #modal.show').length) {

            } else {
                create();
            }
        });

        function reloadDt() {
            if ($('#modal.in, #modal.show').length) {

            } else if ($('#editModal.in, #editModal.show').length) {

            } else {
                table.ajax.reload(null, false);
            }
        }
        Mousetrap.bind('ctrl+shift+r', function(e) {
            e.preventDefault();
            reloadDt();
        });
        Mousetrap.bind('ctrl+shift+s', function(e) {
            e.preventDefault();
            if ($('#modal.in, #modal.show').length) {
                $("#FloorForm").trigger('submit');
            } else {
                alert("Not Calling");
            }
        });
        Mousetrap.bind('ctrl+shift+u', function(e) {
            e.preventDefault();
            if ($('#editModal.in, #editModal.show').length) {
                $("#editFloorForm").trigger('submit');
            } else {
                alert("Not Calling");
            }
        });
        Mousetrap.bind('esc', function(e) {
            e.preventDefault();
            if ($('#editModal.in, #editModal.show').length) {
                $("#editModal").modal('hide');
            } else if ($('#modal.in, #modal.show').length) {
                $('#modal').modal('hide');
            }
        });
    </script>



@endsection

$('.inputProfile').attr({'disabled': 'disabled'})

$('.inputProfile').css("background-color","#d6d6d6")

$('.property input').attr({
    'disabled': 'disabled'
})
$('.property input').css("background-color","#d6d6d6")

$('.delete-button').css("display","none")

$().ready(function() {
     $('#update_button').click(function() {
        
        $('.inputProfile').each(function() {
            if ($(this).attr('disabled')) {
                $(this).removeAttr('disabled');
                $(this).css("background-color","white")
                $('#update_button').text('SAVE')
            }
            else {
                $(this).attr({'disabled': 'disabled'});
                $(this).css("background-color","#d6d6d6")
                $('#update_button').text('UPDATE')
            }
        });
    });
});


// update user profile 

$(document).on('blur','.user input',  function(){
    var sUserId = $(this).parent().attr('id')
    var sUserUpdateKey = $(this).attr('data-update')
    var sUserNewValue = $(this).val()
    console.log('sUserId', sUserId)
    console.log('sUserUpdateKey', sUserUpdateKey)
    console.log('sUserNewValue', sUserNewValue)
    $.ajax({
        url : "api-update-user-profile.php",
        method : "POST",
        data : {id:sUserId, key:sUserUpdateKey, value:sUserNewValue}
    })
    .done(function(){
        console.log('User has been updated')
    })
})

// update agent profile

$(document).on('blur','.agent input',  function(){
    var sAgentId = $(this).parent().attr('id')
    var sAgentUpdateKey = $(this).attr('data-update')
    var sAgentNewValue = $(this).val()
    console.log('sAgentId', sAgentId)
    console.log('sAgentUpdateKey', sAgentUpdateKey)
    console.log('sAgentNewValue', sAgentNewValue)
    $.ajax({
        url : "api-update-agent-profile.php",
        method : "POST",
        data : {id:sAgentId, key:sAgentUpdateKey, value:sAgentNewValue}
    })
    .done(function(){
        console.log('Agent has been updated')
    })
})

$('form#frmImage').submit(function(){
    var form_data = new FormData(this);
    $.ajax({
        url: "api-upload-profile-image.php",
        method: "POST",
        dataType: "JSON",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend:function(){
            $('#uploaded_image').html("<label class='text-success'> Image uploading...</label>");
            
        }
    }).done(function(data){
        console.log('hello')
        $('#uploaded_image').html(data);
        // $(".profile-image").show();
        
    }).fail(function(){
        console.log('Failed');
    })
})

// profile

function initProperties() {
    
}


$('form#property_upload').submit(function(e){
    var propertyFormData = new FormData(this)
    e.preventDefault();
    
    $.ajax({
        url : "api-upload-property.php", //the end point, "file"
        method : "POST", 
        data : propertyFormData, 
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json' 
        
    }).done(function (data){
            const property = data.property;
            console.log('hello');
            if(data.status === 1) {
                var divNewProperty = `
                <div class="property" id="${property.id}">
                <form method="POST"  id="${property.id}" class="indiv-property">
                    <div class="image-btn"> 
                        <img style="width: 150px; height: 150px; object-fit: cover;" src="images/${property.image}" alt="">
                        <div class="edit_property_btn" data-id="${property.id}" style="background-color:#f0e370; text-align: center; color:black; height:40px; 
                        border-radius: 5px; width:150px; padding-top: 10px;">Edit</div> 
                    </div>
                    <div class="input-property">
                        <input data-update="price" name="newPrice" type="number" data-type="integer" value="${property.price}" placeholder="Price">
                        <input data-update="bathrooms" name="newBathroom" type="number" data-type="integer" value="${property.bathrooms}" placeholder="Bathrooms">
                        <input data-update="bedrooms" name="newBedroom" type="number" data-type="integer" value="${property.bedrooms}" placeholder="Bedrooms">
                        <input data-update="surface" name="newSurface" type="number" data-type="integer" value="${property.surface}" placeholder="Surface">
                        <input data-update="address" name="newAddress" type="text" data-type="string" data-min="3" data-max="3000" value="${property.address}" placeholder="Address">
                        <input data-update="zipcode" name="newZipcode" type="text" data-type="string" data-min="3" data-max="10" value="${property.zipcode}" placeholder="Zipcode">
                        <button type="button" onclick="deleteProperty()" class="delete-new-button" data-path="${property.image}" data-id="${property.id}">DELETE</button>
                    </div>
                </form>
                </div>
                `
                $('.delete-new-button').css("display","none")
                $('#property_container').prepend(divNewProperty)
                // $('.property input').attr({
                //     'disabled': 'disabled'
                // })
                
                // $('.property input').css("background-color","#d6d6d6")
            }
            

    }).fail(function(xhr, textStatus, errorThrown){
        console.log(xhr, textStatus, errorThrown);
    })
})


function deleteProperty(){
   
        var property_delete_id = $('.delete-new-button').attr('data-id')
        var property_image_id = $('.delete-new-button').attr('data-path')
        console.log(property_delete_id, property_image_id);
        
        $.ajax({
            url : "api-delete-property.php", //the end point, "file"
            method : "POST", 
            data : {id:property_delete_id, path:property_image_id}
        }).done( function(data){
    
            console.log(`Property ${property_delete_id} deleted!'`); 
    
            $(`#${property_delete_id}`).remove(data);
        })

}

$('.delete-button').click(function(e){
    e.preventDefault();
    var property_delete_id = $(this).attr('data-id')
    var property_image_id = $(this).attr('data-path')
    const that = this;
    console.log(property_delete_id, property_image_id);
    
    $.ajax({
        url : "api-delete-property.php", //the end point, "file"
        method : "POST", 
        data : {id:property_delete_id, path:property_image_id}
    }).done( function(){

        console.log(`Property ${property_delete_id} deleted!`); 

        $(that).closest(".property").remove();
    })
})


$(document).on('blur','.property input',  function(e){
    e.preventDefault();
    console.log('calling update property');
    var property_update_id = $(this).parent().attr('id')
    var sUpdateKey = $(this).attr('data-update')
    var sNewValue = $(this).val()
    console.log('property_update_id', property_update_id)
    console.log('sUpdateKey', sUpdateKey)
    console.log('sNewValue', sNewValue)
    $.ajax({
        url : "api-update-property.php", //the end point, "file"
        method : "POST", 
        data : {
            id:property_update_id, 
            key:sUpdateKey,
            value:sNewValue
        }
    }).done( function(){
            console.log('all good in the hood');
        // location.reload();
    })
})

$('.edit_property_btn').click(function() {
    var property_id = $(this).attr('data-id');
    console.log(property_id)
    $(`#${property_id}.property input`).each(function() {
        if ($(this).attr('disabled')) {
            $(this).removeAttr('disabled')
            $(this).css("background-color","white")
            $('.delete-new-button').css("display","block")
            $('.delete-button').css("display","block")
        }
        else {
            $(this).attr({
                'disabled': 'disabled'})
            $(this).css("background-color","#d6d6d6")
            $('.delete-new-button').css("display","none")
            $('.delete-button').css("display","none")
            
        }
    });
})

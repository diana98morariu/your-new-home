//signup agent
$('#signup_button_agent').click(function(event){
    event.preventDefault()
    console.log('test')
    // var sName = $('#txtName').val()
    // var sEmail = $('#txtEmail').val()
    // var sLastName = $('#txtLastName').val()
    // var sPassword = $('#txtPassword').val()
    // console.log(sName, sEmail, sLastName, sPassword)
    console.log($('form').serialize())
    $.ajax({
        url : "api-signup-agent.php",
        method: "POST",
        data : $('form').serialize(), // create the form to be passed
        dataType:"JSON"
    })
    .done(function(response){
        if( response.status === 1 ){
            window.location='login.php'
        }else{
            $('#error_message_agent').text(response.message)
        }
        console.log(response)
    })
    .fail()

})

//signup user
$('#signup_button_user').click(function(event){
    event.preventDefault()
    console.log('test')
    // var sName = $('#txtName').val()
    // var sEmail = $('#txtEmail').val()
    // var sLastName = $('#txtLastName').val()
    // var sPassword = $('#txtPassword').val()
    // console.log(sName, sEmail, sLastName, sPassword)
    console.log($('form').serialize())
    $.ajax({
        url : "api-signup-user.php",
        method: "POST",
        data : $('form').serialize(), // create the form to be passed
        dataType:"JSON"
    })
    .done(function(response){
        if( response.status === 1 ){
            window.location='login.php'
        }else{
            $('#error_message_user').text(response.message)
        }
        console.log(response)
    })
    .fail()

})
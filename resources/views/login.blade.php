<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
    span{
        color: red;
    }
</style>

<h1> login form</h1>

<form id="login_form">

<input type="text"  name="email" placeholder="enter name">
<br>
<span class="error email_err"></span>
<br>
<input type="password"  name="password" placeholder="enter name" >
<br>
<span class="error password_err"></span>
<br>

<input type="submit" value="login">

</form>

<p class="result"></p>
<script>

    $(document).ready(function(){
        $("#login_form").submit(function(event){
          event.preventDefault();

          var formData = $(this).serialize();
          $.ajax({
            url:"http://127.0.0.1:8000/api/login",
            type: "GET",
            data:formData,
            success:function(data){
                if(data.success){
                     $(".result").text(data.msg);
                }
                else{
                    printErrorMsg(data);
                }
                console.log(data);
            }
          })

        });
    });

    function printErrorMsg(msg){
        $(".error").text("");
        $.each(msg , function(key , value){
           $("."+key+"_err").text(value);
        });
    }

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
    span{
        color: red;
    }
</style>

<h1> rigester form</h1>

<form id="register_form">

<input type="text" name="name" placeholder="enter name" >
<br>
<span class="error name_err"></span>
<br>
<input type="text"  name="email" placeholder="enter name">
<br>
<span class="error email_err"></span>
<br>
<input type="password"  name="password" placeholder="enter name" >
<br>
<span class="error password_err"></span>
<br>
<input type="password"  name="password_confirmation" placeholder="enter password_confirmation" >
<br>
<span class="error password_confirmation_err"></span>
<br>
<input type="submit" value="register">

</form>

<p class="result"></p>
<script>

    $(document).ready(function(){
        $("#register_form").submit(function(event){
          event.preventDefault();

          var formData = $(this).serialize();
          $.ajax({
            url:"http://127.0.0.1:8000/api/rigester",
            type: "GET",
            data:formData,
            success:function(data){
                if(data.msg){
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
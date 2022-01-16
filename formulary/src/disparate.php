
<?php
    

        function disparate(){
       
            $email->add(
                subject:"You have an important mail", 
                body:"<h1> Your register was alredy maded!</h1> <p> Congratulations <3 .</p>", 
                recipient_name:"Aline",
                recipient_email:"alinealv.silv@gmail.com",
                
                
                )->send();
                if(!$email->error()){
                 // header('Location: '.index.php);//login.php
                  return true;
                
                }
                else{
                  $email->error()->getMessage();
                }
           
        }
       
       





?>


<script>

</script>

       
       

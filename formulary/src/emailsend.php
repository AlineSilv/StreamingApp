<?php

namespace Theop\Fullphp;

use exception; //para fazer "erros"
use stdclass; // montar emial para fazer os disparos através do componente.
use PHPMailer\PHPMailer\PHPMailer;


Class emailsend{ // namespace's
    /** @var PHPMailer */
    private $mail;
    /** @var stdclass */
    private $data; //stdclass
    /** @var exception */
    private $error; //print de rros, logs etc.

    public function __construct(){ // abstração de configuração e preparo de objetos.

        $this->mail = new PHPMailer();
        $this->data = new stdclass();
        //Padrão de mensagem
        $this->mail->isSMTP(); //sempre um disparo por um servidor SMTP.
        $this->mail->isHTML(); //sempre o body do email, será com conteúdo html.
        $this->mail->setLanguage(langcode:"br"); //configuração de idioma.
        
        //Padrão de Autenticação
        $this->mail->SMTPAuth = true; //Autenticação do servidor SMTP usando -  SMTPAuth (authentication).
        $this->mail->SMTPSecure = false ; // tls ou ssl, precisa ser configurado.
        $this->mail->CharSet="Utf-8";
        $this->mail->SMTPDebug = 2;

        //Autenticação
        $this->mail->Host       = "smtp.gmail.com";                   //Set the SMTP server to send through
        $this->mail->Username   = "alineas.study@gmail.com";                     //SMTP username
        $this->mail->Password   = "";                       //Enable implicit TLS encryption
        $this->mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //CONFIGURAÇÃO completa, necessário compor mensagem
    }
             //adicionando novos emails, montagem de email para concatenar com novos métodos, attachment, send.
    public function add(string $subject, string $body, string $recipient_name, string $recipient_email ): emailsend{ //retornando objeto.

        $this->data->subject=$subject;
        $this->data->body=$body;
        $this->data->recipient_name=$recipient_name;
        $this->data->recipient_email=$recipient_email;
        return $this; // retornar objeto
        
    }
                 //anexar
    public function attach(string $filepath, string $filename): emailsend{  //possibilidade de fazer vários anexos no mesmo email.
         
        $this->data->attach[$filepath]=$filename;

    }
         //disparo do email, todas as alterações podem ser feitas em config.
    public function send(string $from_name= "Aline", string $from_email= "alineas.study@gmail.com"): bool{ //retorno é boolean, pois se conseguimos disparar, retornamos true caso contrário false.

        try{
            
            $this->mail->Subject= $this->data->subject; //assunto.
            $this->mail->msgHTML($this->data->body); //corpo da mensagem.  MsgHTML - método
            $this->mail->AddAddress($this->data->recipient_email, $this->data->recipient_name); // requisições de para onde encaminhar o email, destinatário.(address:"", name: "")
            $this->mail->setFrom($from_email, $from_name);//Quem disparou o email. (addres: "", name:"").
            
            $this->mail->send();
            
            if(!empty($this->data->attach)){
                foreach($this->data->attach as $path=> $name){
                    $this->mail->AddAttachment($path, $name);

                }
            }
            echo"<script>alert(' You are register');</script>";
            return true;

        }

        catch(Exception $exception){
            $this->error = $exception; // armazenamos o objeto de exceção, no parâmetro para consultar.
            echo"<script>alert('You have an error');</script>";
            return false;
        }
    }

    public function error(): ?Exception{ // pode ser nulo ou exception
        
        return $this->error;
    }




}








?>

<?php

    /// Change this if you want to configure mail system
    $admin_mail = "cheese.software.mailing@gmail.com";
    $website_url = "localhost/RentIt";
    $sender_host = "no-reply@gmail.com";
    /// ==========

    $headers = "From: $sender_host\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";

    if(isset($_POST["mail"])){
        $mail = $_POST["mail"];
        unset($_POST["mail"]);

        //$mail = ["to"=>"aleksanderheesemail@gmail.com", "case"=>"acceptation", "order"=>["number"=>"4T42187468", "item"=>"Futsal Ball", "name"=>"Ale Hee", "email"=>"alehee@mail.com", "phone"=>"458105832", "start"=>"2021-09-04", "end"=>"2021-09-05", "accept"=>true]];

        $to = $mail["to"];
        $subject = "Rent It Subject";
        $body_content = ['title'=>'', 'body'=>''];

        $body = '<html>';
        $body .= '<head><style>';
        $body .= '.cont { font-size:large; margin:10px; }';
        $body .= '</style></head>';
        $body .= '<body>';
        $body .= '<h1 style="text-align:center; color:#79d279; font-weight: 600; font-style: italic;">RENT IT</h1>';
        
        $case = $mail["case"];
        switch($case){
            case "confirmation":
                $subject = "[RENT IT] We received your order ".$mail["order"]["number"];
                $body_content["title"] = "Order <b>".$mail["order"]["number"]."</b> has been received!";
                $body_content['body'] .= '<div class="cont">Item: <b>'.$mail["order"]["item"].'</b></div>';
                $body_content['body'] .= '<div class="cont">Start: <b>'.$mail["order"]["start"].'</b></div>';
                $body_content['body'] .= '<div class="cont">End: <b>'.$mail["order"]["end"].'</b></div>';
                $body_content['body'] .= '<p class="cont">Our administrator will consider your order as soon as possible. Wait for the acceptation mail soon!</p>';
            break;
            case "confirmation_admin":
                $to = $admin_mail;
                $subject = "[RENT IT] New order has been received ".$mail["order"]["number"];
                $body_content["title"] = "Order <b>".$mail["order"]["number"]."</b> has been received!";
                $body_content['body'] .= '<div class="cont">Item: <b>'.$mail["order"]["item"].'</b></div>';
                $body_content['body'] .= '<div class="cont">Start: <b>'.$mail["order"]["start"].'</b></div>';
                $body_content['body'] .= '<div class="cont">End: <b>'.$mail["order"]["end"].'</b></div>';
                $body_content['body'] .= '<div class="cont">Name: <b>'.$mail["order"]["name"].'</b></div>';
                $body_content['body'] .= '<div class="cont">E-mail: <b>'.$mail["order"]["email"].'</b></div>';
                $body_content['body'] .= '<div class="cont">Phone: <b>'.$mail["order"]["phone"].'</b></div>';
                $body_content['body'] .= '<p class="cont">Head to admin panel as soon as possible to accept or reject the order.</p>';
                $body_content['body'] .= '<p class="cont">Link to the website is <a href="'.$website_url.'" target="_blank">here</a></p>';
            break;
            case "acceptation":
                if($mail["order"]["accept"]){
                    $subject = "[RENT IT] Order ".$mail["order"]["number"]." has been accepted!";
                    $body_content["title"] = "We're happy to accept your order!";
                }
                else{
                    $subject = "[RENT IT] Order ".$mail["order"]["number"]." has been rejected.";
                    $body_content["title"] = "We're sorry to reject your order";
                }
                
                $body_content['body'] .= '<div class="cont">Order: <b>'.$mail["order"]["number"].'</b></div>';
                $body_content['body'] .= '<div class="cont">Item: <b>'.$mail["order"]["item"].'</b></div>';
                $body_content['body'] .= '<div class="cont">Start: <b>'.$mail["order"]["start"].'</b></div>';
                $body_content['body'] .= '<div class="cont">End: <b>'.$mail["order"]["end"].'</b></div>';

                if($mail["order"]["accept"]){
                    $body_content['body'] .= '<p class="cont" style="color:green; text-align:center;">YOUR ORDER HAS BEEN ACCEPTED!</p>';
                    $body_content['body'] .= '<p class="cont">Head to our office at the start date of your order to collect gear. See you soon!</p>';
                }
                else{
                    $body_content['body'] .= '<p class="cont" style="color:red; text-align:center;">YOUR ORDER HAS BEEN REJECTED</p>';
                    $body_content['body'] .= '<p class="cont">We can not complete your order at the moment and we canceled it. Try again in another time and we will do our best to help you!</p>';
                }
            break;
            case "cancelation":
                $subject = "Subject";
                $body_content["title"] = "";
            break;
            case "cancelation_admin":
                $to = $admin_mail;
                $subject = "Subject";
                $body_content["title"] = "";
            break;
            default:

            break;
        }

        $body .= '<h2 style="text-align:center; color:black; font-weight: 600;">'.$body_content["title"].'</h2>';
        $body .= $body_content['body'];
        $body .= '<p style="text-align:center; color:gray; font-size:small;">Mail generated automatically '.date("Y-m-d H:i:s",time()).'</p>';
        $body .= '</body></html>';

        try{
            mail($to, $subject, $body, $headers);
            echo json_encode(array("message"=>true));
        }catch(Exception $e) {
            echo json_encode(array("message"=>$e->getMessage()));
        }
    }
    
?>
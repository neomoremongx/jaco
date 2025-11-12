 <?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//required files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if form fields exist before accessing them
    $name = isset($_POST["name"]) ? $_POST["name"] : '';
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    $phone = isset($_POST["phone"]) ? $_POST["phone"] : '';
    $service = isset($_POST["service"]) ? $_POST["service"] : '';
    $message = isset($_POST["message"]) ? $_POST["message"] : '';

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($service) || empty($message)) {
        echo "
        <script>
         alert('Error: Please fill in all required fields.');
         document.location.href = 'index.html';
        </script>
        ";
        exit;
    }

    try {
        $mail = new PHPMailer(true);

        //Server settings
        $mail->isSMTP();                              //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;             //Enable SMTP authentication
        $mail->Username   = 'neomoremongx@gmail.com';   //SMTP write your email
        $mail->Password   = 'pxcosqmpbjlodmyw';      //SMTP password
        $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
        $mail->Port       = 465;                                    

        //Recipients
        $mail->setFrom($email, $name); // Sender Email and name
        $mail->addAddress('neomoremongx@gmail.com');     //Add a recipient email  
        $mail->addReplyTo($email, $name); // reply to sender email

        //Content
        $mail->isHTML(true);               //Set email format to HTML
        $mail->Subject = "Legal Consultation Request - Jaco Du Plooy Attorneys";   // email subject headings
        
        // Map service values to readable text
        $service_types = [
            'civil' => 'Civil Litigation',
            'property' => 'Property Law',
            'family' => 'Family Law',
            'contract' => 'Contract Law',
            'business' => 'Business Law',
            'estate' => 'Estate Planning',
            'other' => 'Other Legal Service'
        ];
        
        $service_text = isset($service_types[$service]) ? $service_types[$service] : $service;

        $formattedMessage = "
        <html>
        <head>
            <style>
                :root {
                    --primary: #1e88e5;
                    --primary-dark: #1565c0;
                    --accent: #e3f2fd;
                    --white: #ffffff;
                    --light: #f8f9fa;
                    --dark: #333333;
                    --gray: #666666;
                    --border: #e0e0e0;
                }
                
                body {
                    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
                    line-height: 1.6;
                    color: var(--dark);
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                }
                
                .header {
                    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
                    color: white;
                    padding: 30px;
                    text-align: center;
                    border-radius: 8px 8px 0 0;
                }
                
                .content {
                    background: var(--light);
                    padding: 30px;
                    border: 1px solid var(--border);
                    border-top: none;
                }
                
                .details {
                    background: white;
                    padding: 25px;
                    border-radius: 8px;
                    margin: 20px 0;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                }
                
                .detail-row {
                    display: flex;
                    margin-bottom: 12px;
                    padding: 8px 0;
                    border-bottom: 1px solid var(--border);
                }
                
                .detail-label {
                    font-weight: bold;
                    color: var(--primary);
                    width: 150px;
                    flex-shrink: 0;
                }
                
                .footer {
                    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
                    color: white;
                    padding: 25px;
                    text-align: center;
                    border-radius: 0 0 8px 8px;
                    margin-top: 20px;
                }
                
                .legal-message {
                    background: var(--accent);
                    padding: 20px;
                    border-radius: 6px;
                    border-left: 4px solid var(--primary);
                    margin: 15px 0;
                }
            </style>
        </head>
        <body>
            <div class=\"header\">
                <h1>New Legal Consultation Request</h1>
                <p>Jaco Du Plooy Attorneys | Trusted Legal Solutions Since 2017</p>
            </div>
            
            <div class=\"content\">
                <div class=\"details\">
                    <div class=\"detail-row\">
                        <span class=\"detail-label\">Client Name:</span>
                        <span class=\"detail-value\">" . htmlspecialchars($name) . "</span>
                    </div>
                    
                    <div class=\"detail-row\">
                        <span class=\"detail-label\">Email:</span>
                        <span class=\"detail-value\">" . htmlspecialchars($email) . "</span>
                    </div>
                    
                    <div class=\"detail-row\">
                        <span class=\"detail-label\">Phone:</span>
                        <span class=\"detail-value\">" . htmlspecialchars($phone) . "</span>
                    </div>
                    
                    <div class=\"detail-row\">
                        <span class=\"detail-label\">Service Needed:</span>
                        <span class=\"detail-value\">" . htmlspecialchars($service_text) . "</span>
                    </div>
                </div>
                
                <h3 style=\"color: var(--primary); margin-bottom: 10px;\">Legal Matter Details:</h3>
                <div class=\"legal-message\">
                    <p style=\"margin: 0; white-space: pre-line;\">" . htmlspecialchars($message) . "</p>
                </div>
                
                <p style=\"margin-top: 20px;\">Please contact <strong>" . htmlspecialchars($name) . "</strong> at " . htmlspecialchars($email) . " or " . htmlspecialchars($phone) . " to schedule a consultation.</p>
            </div>
            
            <div class=\"footer\">
                <p style=\"margin: 0; font-size: 14px;\">
                    <strong>Jaco Du Plooy Attorneys</strong><br>
                    Office D2, Totius Park, 24 Totius Street, Potchefstroom, South Africa<br>
                    Phone: 018 175 0072 | Email: jacodup.att@gmail.com<br>
                    © " . date('Y') . " Jaco Du Plooy Attorneys. All rights reserved.
                </p>
            </div>
        </body>
        </html>
        ";

        $mail->Body = $formattedMessage; //email message
        // Success sent message alert
        $mail->send();

        // Auto-reply to client
        $autoReplyMail = new PHPMailer(true);

        try {
            //Server settings - same as your main email
            $autoReplyMail->isSMTP();
            $autoReplyMail->Host       = 'smtp.gmail.com';
            $autoReplyMail->SMTPAuth   = true;
            $autoReplyMail->Username   = 'neomoremongx@gmail.com';
            $autoReplyMail->Password   = 'pxcosqmpbjlodmyw';
            $autoReplyMail->SMTPSecure = 'ssl';
            $autoReplyMail->Port       = 465;

            //Recipients
            $autoReplyMail->setFrom('neomoremongx@gmail.com', 'Jaco Du Plooy Attorneys');
            $autoReplyMail->addAddress($email, $name); // Send to the client
            $autoReplyMail->addReplyTo('neomoremongx@gmail.com', 'Jaco Du Plooy Attorneys');

            //Content
            $autoReplyMail->isHTML(true);
            $autoReplyMail->Subject = "Consultation Request Received - Jaco Du Plooy Attorneys";
            
            $autoReplyMessage = "
            <html>
            <head>
                <style>
                    :root {
                        --primary: #1e88e5;
                        --primary-dark: #1565c0;
                        --accent: #e3f2fd;
                        --white: #ffffff;
                        --light: #f8f9fa;
                        --dark: #333333;
                        --gray: #666666;
                        --border: #e0e0e0;
                    }
                    
                    body {
                        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
                        line-height: 1.6;
                        color: var(--dark);
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                    }
                    
                    .header {
                        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
                        color: white;
                        padding: 30px;
                        text-align: center;
                        border-radius: 8px 8px 0 0;
                    }
                    
                    .content {
                        background: var(--light);
                        padding: 30px;
                        border: 1px solid var(--border);
                        border-top: none;
                    }
                    
                    .footer {
                        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
                        color: white;
                        padding: 25px;
                        text-align: center;
                        border-radius: 0 0 8px 8px;
                        margin-top: 20px;
                    }
                    
                    .thank-you {
                        font-size: 18px;
                        color: var(--primary);
                        margin-bottom: 20px;
                        font-weight: bold;
                    }
                    
                    .contact-info {
                        background: white;
                        padding: 20px;
                        border-radius: 8px;
                        margin: 20px 0;
                        border-left: 4px solid var(--primary);
                    }
                </style>
            </head>
            <body>
                <div class=\"header\">
                    <h1>Thank You for Your Consultation Request!</h1>
                    <p>Jaco Du Plooy Attorneys | Trusted Legal Solutions Since 2017</p>
                </div>
                
                <div class=\"content\">
                    <div class=\"thank-you\">Dear " . htmlspecialchars($name) . ",</div>
                    
                    <p>Thank you for reaching out to Jaco Du Plooy Attorneys. We have received your consultation request for <strong>" . htmlspecialchars($service_text) . "</strong> and our team will review your legal matter promptly.</p>
                    
                    <div class=\"contact-info\">
                        <h3 style=\"color: var(--primary); margin-top: 0;\">Your Consultation Summary</h3>
                        <p style=\"margin: 5px 0;\"><strong>Service Needed:</strong> " . htmlspecialchars($service_text) . "</p>
                        <p style=\"margin: 5px 0;\"><strong>Contact Phone:</strong> " . htmlspecialchars($phone) . "</p>
                        <p style=\"margin: 5px 0;\"><strong>Submitted:</strong> " . date('F j, Y \a\t g:i A') . "</p>
                    </div>
                    
                    <p><strong>We typically respond within 24 hours.</strong></p>
                    
                    <div class=\"contact-info\">
                        <h3 style=\"color: var(--primary); margin-top: 0;\">Our Contact Information</h3>
                        <p style=\"margin: 5px 0;\"><strong>Phone:</strong> 018 175 0072</p>
                        <p style=\"margin: 5px 0;\"><strong>Email:</strong> jacodup.att@gmail.com</p>
                        <p style=\"margin: 5px 0;\"><strong>Address:</strong> Office D2, Totius Park, 24 Totius Street, Potchefstroom</p>
                        <p style=\"margin: 5px 0;\"><strong>Business Hours:</strong> Mon-Fri: 8:00 AM - 5:00 PM, Sat: By Appointment</p>
                    </div>
                    
                    <p>For urgent matters, please feel free to call us directly at 018 175 0072.</p>
                    
                    <p>Best regards,<br>
                    <strong>The Jaco Du Plooy Attorneys Team</strong></p>
                </div>
                
                <div class=\"footer\">
                    <p style=\"margin: 0; font-size: 14px;\">
                        <strong>Jaco Du Plooy Attorneys</strong><br>
                        Trusted Legal Solutions Since 2017<br>
                        © " . date('Y') . " Jaco Du Plooy Attorneys. All rights reserved.
                    </p>
                </div>
            </body>
            </html>
            ";
            
            $autoReplyMail->Body = $autoReplyMessage;
            $autoReplyMail->send();
            
        } catch (Exception $e) {
            // Optional: Log error but don't show to user to avoid confusion
            error_log("Auto-reply failed: " . $autoReplyMail->ErrorInfo);
        }

        echo "
        <script> 
         alert('Thank you! Your consultation request has been sent successfully. We will contact you shortly.');
         document.location.href = 'index.html';
        </script>
        ";
        
    } catch (Exception $e) {
        // Error message
        echo "
        <script> 
         alert('Sorry, there was an error sending your consultation request. Please try again or contact us directly at 018 175 0072.');
         document.location.href = 'index.html';
        </script>
        ";
    }
} else {
    // If not a POST request, redirect to home
    header("Location: index.html");
    exit;
}

?>
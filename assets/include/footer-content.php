<?php


$transmitResponseSubscribe = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['subscribeButton'])) {
        if (isset($_POST['userNameSubscribe'])) {
            $UserNameSubscribe = htmlspecialchars(strip_tags(trim($_POST['userNameSubscribe'])));
        }
        if (isset($_POST['userEmailSubscribe'])) {
            $UserEmailSubscribe = htmlspecialchars(strip_tags(trim($_POST['userEmailSubscribe'])));
        }
        $UserSubjectSubscribe = "Tualatin Top Bakery: Subscribe";
        $SendEmailToSubscribe = "logan.testa@outlook.com";


        /* Validation Time */
        $PassedValidation = true;
        if (Trim($UserNameSubscribe) === "") {
            $PassedValidation = false;
        }
        if (Trim($UserEmailSubscribe) === "") {
            $PassedValidation = false;
        }

        /* More advanced e-mail validation */
        if (!filter_var($UserEmailSubscribe, FILTER_VALIDATE_EMAIL)) {
            $PassedValidation = false;
        }
        if ($PassedValidation === false) {
            $transmitResponseSubscribe .= "Sorry validation failed.  Please check all fields again.";
        }

        /* Create the e-mail body. */
        $BodySubscribe = "This user has requested subscription to our bakery customer emails.\n";
        $BodySubscribe .= "User Name: " . $UserNameSubscribe . "\n";
        $BodySubscribe .= "User Email: " . $UserEmailSubscribe . "\n";

        /* Send the e-mail. */
        $SuccessfulSubmission = mail($SendEmailToSubscribe, $UserSubjectSubscribe, $BodySubscribe, "From: <$UserEmailSubscribe>");
        if ($SuccessfulSubmission) {
            $transmitResponseSubscribe .= $UserNameSubscribe . ", your form was successfully submitted.  You are now subscribed to our specials and updates!";
        } else if ($SuccessfulSubmission === false) {
            $transmitResponseSubscribe .= " Submission failed. Please try again.";
        }
    }
}
?>




<footer>
    <div class="content-wrapper inner-wrapper">     
        <div class="content-row">
            <div class="footer__copyright">
                <p>&copy; <?php echo date("Y"); ?> Tualatin Top Bakery. All Rights Reserved.</p>
            </div>

            <script type="text/x-template" id="modal-template">
                <transition name="modal">
                <div class="modal__mask subscribe-modal">
                <div class="modal__wrapper">
                <div class="modal__container">
                <div class="modal__header">
                <slot name="header">
                <h3>Subscribe</h3>
                </slot>
                </div>
                <div class="modal__body">
                <slot name="body">
                <p>This is the modal body text.</p>        
                </slot>
                </div>
                <div class="modal__footer">
                <slot name="footer">
                Footer text here.
                </slot>
                <div class="modal__close-button" @click="$emit('close')">
                X
                </div>
                </div>
                </div>
                </div>
                </div>              
                </transition>
            </script>       

            <div class="footer__subscribe">
                <div class="footer__subscribe-button" @click="showModal=true">

                    <div class="footer__subscribe-button__bg"><span class="footer__subscribe-button__text">Subscribe for Discounts/Cookies!</span></div>
                    <div class="footer__subscribe-button__bg--hover"><span class="footer__subscribe-button__text">Subscribe for Discounts/Cookies!</span></div>   
                </div>
                <modal v-if="showModal" @close="showModal=false">
                    <h3 slot="header">Subscribe for News + Coupons</h3>
                    <div slot="body">
                        <p>Get news on upcoming events and sweet discounts on bakery products!  All new subscribers get a free cookie coupon 
                            in their inbox!</p>
                        <form class="contact-container__form" id="subscribeToOurCoffeeShop" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="input-container">
                                <label class="input-container__label" for="userNameSubscribe"><strong>Name *</strong></label>
                                <input type="text" id="userNameSubscribe" name="userNameSubscribe" placeholder="Enter Name Here" required="required">    
                            </div>
                            <div class="input-container">
                                <label class="input-container__label" for="userEmailSubscribe"><strong>Email *</strong></label>
                                <input type="email" id="userEmailSubscribe" name="userEmailSubscribe" placeholder="Enter Email Here" required="required"> 
                            </div>
                            <div class="input-container">
                                <button class="input-container__contact-button" id="subscribeButton" name="subscribeButton" type="submit">Subscribe!</button>                          
                            </div>                              
                        </form>
                        <?php if(!empty($transmitResponseSubscribe)) { echo "<div class=\"transmit-response-subscribe\">$transmitResponseSubscribe</div>"; } ?>
                    </div>
                    <div slot="footer">
                        <span>Enjoy!</span>
                    </div>
                </modal>
            </div>

            <div class="footer__social col-sma-4">
                <h4 class="footer__subheader">Social</h4>
                <div class="footer__social-logo facebook">
                    <a href=""><i class="fab fa-facebook-f fa-2x social-icon"><span class="sr-only">Facebook</span></i>
                    </a>
                </div>
                <div class="footer__social-logo instagram">
                    <a href=""><i class="fab fa-instagram fa-2x social-icon"><span class="sr-only">Instagram</span></i></a>
                </div>
                <div class="footer__social-logo twitter">
                    <a href=""><i class="fab fa-twitter fa-2x social-icon"><span class="sr-only">Twitter</span></i></a>
                </div>
            </div>
            <div class="footer__location col-sma-4">
                <h4 class="footer__subheader">Location</h4>
                <div>4422 SW Tualatin-Sherwood Road, Tualatin, Oregon 97062</div>
            </div>
            <div class="footer__hours col-sma-4">
                <h4 class="footer__subheader">Hours</h4>
                <div class="footer__hours__day">Monday-Friday 7:00 AM-8:00 PM</div>
                <div class="footer__hours__day">Saturday 8:00 AM-8:00 PM</div>
                <div class="footer__hours__day">Sunday 8:00 AM-5:00 PM</div>
            </div>
        </div>
    </div>
</footer>
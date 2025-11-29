<div class="page-content header-clear-medium">
        
        <div class="card card-style">
            <div class="content">
            <p class="mb-0 font-600 color-highlight">Get In Touch With Us</p>
                <h1>Contact Us</h1>
                <div class="list-group list-custom-small">
                    <?php if($data->phone <>""): ?>
                    <a href="tel:<?php echo $data->phone; ?>" class="external-link">
                        <i class="fa font-14 fa-phone color-phone"></i>
                        <span><?php echo $data->phone; ?></span>
                        <span class="badge bg-highlight">TAP TO CALL</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <?php endif; if($data->email <>""): ?>
                    <a href="mailto:<?php echo $data->email; ?>" class="external-link">
                        <i class="fa font-14 fa-envelope color-mail"></i>
                        <span><?php echo $data->email; ?></span>
                        <span class="badge bg-highlight">TAP TO MAIL</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <?php endif; if($data->whatsapp <>""): ?>
                    <a href="https://wa.me/234<?php echo $data->whatsapp; ?>" class="external-link">
                        <i class="fab fa-whatsapp font-14  color-phone"></i>
                        <span>Whatsapp</span>
                        <span class="badge bg-highlight">TAP TO MESSAGE</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <?php endif; if($data->whatsappgroup <>""): ?>
                    <a href="<?php echo $data->whatsappgroup; ?>" class="external-link">
                        <i class="fab font-14 fa-whatsapp color-phone"></i>
                        <span>Whatsapp Group</span>
                        <span class="badge bg-highlight">TAP TO JOIN</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <?php endif; if($data->facebook <>""): ?>
                    <a href="<?php echo $data->facebook; ?>" class="external-link">
                        <i class="fab font-14 fa-facebook color-mail"></i>
                        <span>Facebook</span>
                        <span class="badge bg-highlight">TAP TO JOIN</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <?php endif; if($data->instagram <>""): ?>
                    <a href="<?php echo $data->instagram; ?>" class="external-link">
                        <i class="fab font-14 fa-instagram text-danger"></i>
                        <span>Instagram</span>
                        <span class="badge bg-highlight">TAP TO JOIN</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <?php endif; if($data->twitter <>""): ?>
                    <a href="<?php echo $data->twitter; ?>" class="external-link">
                        <i class="fab font-14 fa-twitter text-primary"></i>
                        <span>Twitter</span>
                        <span class="badge bg-highlight">TAP TO JOIN</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <?php endif; if($data->telegram <>""): ?>
                    <a href="https://t.me/<?php echo $data->telegram; ?>" class="external-link">
                        <i class="fab font-14 fa-telegram text-primary"></i>
                        <span>Telegram</span>
                        <span class="badge bg-highlight">TAP TO JOIN</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <?php endif; ?>
                    
                    

                </div>


            </div>

        </div>

        <div class="card card-style">

            <div class="content">
           
                <p class="mb-0 font-600 color-highlight">Get In Touch With Us</p>
                <h1>Direct Message</h1>
                <form method="post" class="contactForm" id="message-form">
                        <fieldset>
                            <div class="form-field form-name">
                                <label class="contactNameField color-theme" for="contactNameField">Name:<span>(required)</span></label>
                                <input type="text" name="name" placeholder="Name" value="" class="round-small" id="contactNameField" required />
                            </div>
                            <div class="form-field form-email">
                                <label class="contactEmailField color-theme" for="contactEmailField">Email:<span>(required)</span></label>
                                <input type="email" name="email" placeholder="Email" value="" class="round-small" id="contactEmailField" required  />
                            </div>
                            <div class="form-field form-name">
                                <label class="contactSubjectField color-theme" for="contactSubjectField">Subject:<span>(required)</span></label>
                                <input type="text" name="subject" placeholder="Subjet" value="" class="round-small" id="contactSubjectField" required />
                            </div>
                            <div class="form-field form-text">
                                <label class="contactMessageTextarea color-theme" for="contactMessageTextarea">Your Message:<span>(required)</span></label>
                                <textarea name="message" placeholder="Your Message" class="round-small" id="contactMessageTextarea"  required ></textarea>
                            </div>
                            <div class="form-button">
                            <button type="submit" id="message-btn" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                                    Send Message
                            </button>
                            </div>
                        </fieldset>
                    </form>        
            </div>

        </div>

</div>


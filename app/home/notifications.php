<div class="page-content header-clear-medium">
        
        <div class="card card-style">
            <div class="content">
            <p class="mb-0 text-center font-600 color-highlight">All Notifications</p>
                <h1 class="text-center">Notifications</h1>
            </div>
        

        <div class="timeline-body mt-0">
            <div class="timeline-deco"></div>
            <?php if(!empty($data)): foreach($data as $list): ?>
            <div class="timeline-item mt-2">
                <i class="fa fa-envelope bg-blue-dark color-white shadow-l timeline-icon"></i>
                <div class="timeline-item-content rounded-s">
                    <h5 class="font-400 pt-1 pb-1"><b><?php echo $list->subject; ?></b></h5>
                    <h5 class="font-400 pt-1 pb-1">Message: <?php echo $list->message; ?></h5>
                    <h5 class="font-400 pt-1 pb-1"><span class="opacity-30"><?php echo $controller->formatDate($list->dPosted); ?></span></h5>
                </div>
            </div>	
            <?php endforeach; else : ?>
                <div class="timeline-item">
                <i class="fa fa-envelope bg-blue-dark color-white shadow-l timeline-icon"></i>
                <div class="timeline-item-content rounded-s">
                    <h5 class="font-400 pt-1 pb-1 text-danger">
                        <b>No Message Available</b>
                    </h5>
                </div>
            </div>
            <?php endif; ?>	

        </div>
    </div>

        
</div>


<div class="page-content header-clear-medium">
        
        <div class="card card-style">
            <div class="content">
                <div class="d-flex justify-content-between mb-0">
                    <div>
                        <p class="mb-0 font-600 color-highlight">Transaction Details</p>
                        <h1>Data Pin</h1>
                    </div>
                    <div>
                        <a href="print-data-pin?ref=<?php echo $_GET["ref"]; ?>" class="btn btn-info"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>
                <p class="mb-0 font-600 text-danger">Click On The Pin To Copy</p>
                
                <div>
                    <?php if(!empty($data)) : $pins=explode(",",$data->tokens); $sn=explode(",",$data->serial); ?>
                    <?php $network=$data->network; $datasize=$data->datasize; $loadpin="*347*383*3*3*PIN#"; if($datasize=="1.5GB"){$loadpin="*460*6*1# Then PIN or Text PIN to 460"; $checkBal="*131*4#";} ?>
                    <?php if($network == "AIRTEL"){$cardColor="#ff1a1a"; $cardLogo="airtel.png"; $textColor="#ffffff"; $checkBal="*140#";} 
                    else {$cardColor="#ffcc00"; $cardLogo="mtn.png"; $textColor="#000000"; $checkBal="*461*4#";} ?>
                    <?php for($i=0; $i<$data->quantity; $i++): ?>
                          
                                <div class="row border" style="margin:3px;">
                                        <div class="col-4" style="margin:0; padding:0; background-color:<?php echo $cardColor; ?>;">
                                            <div class="text-dark" style="padding:10px;">
                                               
                                                <p style="margin-bottom:5px;"><img src="../../assets/images/icons/<?php echo $cardLogo; ?>" style="width:50px; height:50px;" /></p>
                                                <h6 style="color:<?php echo $textColor; ?>">DATA PIN</h6>
                                                <h6 style="color:<?php echo $textColor; ?>"><?php echo $datasize; ?></h6>
                                                <p style="margin-bottom:0; color:<?php echo $textColor; ?>"><?php echo $sn[$i]; ?></p>
                                            </div>
                                        </div>
                                        
                                        <div class="col-8 bg-white" style="margin:0; padding:0; ">   
                                            <div class="text-center" style="padding:10px;">
                                                
                                                <h6><?php echo strtoupper($data->business); ?></h6>
                                                <button style="background-color:#f2f2f2; border-radius:3rem; padding:7px; width:100%;" onclick="copyToClipboard('<?php echo trim($pins[$i]); ?>')"><h4><?php echo trim($pins[$i]); ?></h4></button>
                                                <p style="margin-bottom:0;"><b>Load <?php echo $loadpin; ?></b> <b>Bal:   <?php echo $checkBal; ?></b></p>
                                                <p>Powered By: <?php echo $sitename; ?></p>
                                            </div>
                                        </div>
                                </div>
                        
                    <?php endfor; endif; ?>
                   
                </div>


            </div>

        </div>

</div>


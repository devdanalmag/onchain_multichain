<div class="page-content header-clear-medium">
        
        <div class="card card-style">
            <div class="content">
                <p class="mb-0 font-600 color-highlight">Our Pricing</p>
                <h1 class="font-20">Networks</h1>
                <table class="table table-bordered table-striped">
                    <tr class="bg-blue-dark">
                        <td class="text-white"><b>Id</b></td>
                        <td class="text-white"><b>Network</b></td>
                    </tr>
                    <?php if(!empty($data)): foreach ($data AS $network): ?>
                        <tr>
                            <td><?php echo $network->nId; ?></td>
                            <td><?php echo $network->network; ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </table> 
                
                <h1 class="font-20">Airtime</h1>
                <p class="text-danger">Scroll Horizontally To View Entire Table</p>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tr class="bg-blue-dark">
                            <td class="text-white"><b>Network</b></td>
                            <td class="text-white"><b>Subscriber</b></td>
                            <td class="text-white"><b>Agents</b></td>
                            <td class="text-white"><b>Vendors</b></td>
                        </tr>
                        <?php if(!empty($data2)): foreach ($data2 AS $airtime): ?>
                            <tr>
                                <td><?php echo $airtime->network; ?></td>
                                <td><?php echo 100 - $airtime->aUserDiscount; ?> % </td>
                                <td><?php echo 100 - $airtime->aAgentDiscount; ?> %</td>
                                <td><?php echo 100 - $airtime->aVendorDiscount; ?> %</td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </table> 
                </div>

                <h1 class="font-20">Data Plan</h1>
                <p class="text-danger">Scroll Horizontally To View Entire Table</p>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tr class="bg-blue-dark">
                            <td class="text-white"><b>Network</b></td>
                            <td class="text-white"><b>Plan Id</b></td>
                            <td class="text-white"><b>Plan</b></td>
                            <td class="text-white"><b>Subscriber</b></td>
                            <td class="text-white"><b>Agents</b></td>
                            <td class="text-white"><b>Vendors</b></td>
                        </tr>
                        <?php if(!empty($data3)): foreach ($data3 AS $plans): ?>
                            <tr>
                                <td><?php echo $plans->network; ?></td>
                                <td><?php echo $plans->pId; ?></td>
                                <td><?php echo "$plans->name ($plans->type) ($plans->day days)"; ?></td>
                                <td>N<?php echo $plans->userprice; ?></td>
                                <td>N<?php echo $plans->agentprice; ?></td>
                                <td>N<?php echo $plans->vendorprice; ?></td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </table>
                </div>

                <h1 class="font-20">Cable TV Provider</h1>
                <table class="table table-bordered table-striped">
                    <tr class="bg-blue-dark">
                        <td class="text-white"><b>Cable Id</b></td>
                        <td class="text-white"><b>Provider</b></td>
                    </tr>
                    <?php if(!empty($data4)): foreach ($data4 AS $cable): ?>
                        <tr>
                            <td><?php echo $cable->cId; ?></td>
                            <td><?php echo $cable->provider; ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </table> 

                <h1 class="font-20">Cable Plan</h1>
                <p class="text-danger">Scroll Horizontally To View Entire Table</p>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tr class="bg-blue-dark">
                            <td class="text-white"><b>Provider</b></td>
                            <td class="text-white"><b>Plan Id</b></td>
                            <td class="text-white"><b>Plan</b></td>
                            <td class="text-white"><b>Subscriber</b></td>
                            <td class="text-white"><b>Agents</b></td>
                            <td class="text-white"><b>Vendors</b></td>
                        </tr>
                        <?php if(!empty($data5)): foreach ($data5 AS $plans): ?>
                            <tr>
                                <td><?php echo $plans->provider; ?></td>
                                <td><?php echo $plans->cpId; ?></td>
                                <td><?php echo "$plans->name ($plans->day days)"; ?></td>
                                <td>N<?php echo $plans->userprice; ?></td>
                                <td>N<?php echo $plans->agentprice; ?></td>
                                <td>N<?php echo $plans->vendorprice; ?></td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </table>
                </div>

                <h1 class="font-20">Electricity Token</h1>
                <table class="table table-bordered table-striped">
                    <tr class="bg-blue-dark">
                        <td class="text-white"><b>Id</b></td>
                        <td class="text-white"><b>Provider</b></td>
                    </tr>
                    <?php if(!empty($data6)): foreach ($data6 AS $exam): ?>
                        <tr>
                            <td><?php echo $exam->eId; ?></td>
                            <td><?php echo $exam->provider; ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </table> 

                <h1 class="font-20">Exam Pin</h1>
                <table class="table table-bordered table-striped">
                    <tr class="bg-blue-dark">
                        <td class="text-white"><b>Exam Id</b></td>
                        <td class="text-white"><b>Provider</b></td>
                        <td class="text-white"><b>Price</b></td>
                    </tr>
                    <?php if(!empty($data7)): foreach ($data7 AS $exam): ?>
                        <tr>
                            <td><?php echo $exam->eId; ?></td>
                            <td><?php echo $exam->provider; ?></td>
                            <td><?php echo $exam->price; ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </table> 


            </div>

        </div>

</div>


<?php
$pending = 0;
$total = 0;
$delivered = 0;

if(count($orders) > 0)
{
    foreach ($orders as $order) {

        ++$total;

        if($order->post_status == TNC\Base\OrderStatus::COMPLETED)
        {
            ++$delivered;
            continue;
        }

        if($order->post_status == TNC\Base\OrderStatus::PENDING
                || $order->post_status == TNC\Base\OrderStatus::PROCESSING
                || $order->post_status == TNC\Base\OrderStatus::ON_HOLD)
        {
            ++$pending;
            continue;
        }


    }
}

 ?>

<div class="wrap">
    <h3>
        Dashboard For Deliveries Today
    </h3>
</div>

 <div class="content">

     <div class="row">
         <div class="col-lg-3 col-xs-6">
           <!-- small box -->
           <div class="small-box bg-aqua">
             <div class="inner">
               <h3><?php echo $total; ?></h3>

               <p>Total Deliveries</p>
             </div>
             <div class="icon">
               <i class="ion ion-bag"></i>
             </div>
             <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
           </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-xs-6">
           <!-- small box -->
           <div class="small-box bg-green">
             <div class="inner">
               <h3> <?php echo $delivered; ?> </h3>

               <p>Completed Deliveries</p>
             </div>
             <div class="icon">
               <i class="ion ion-stats-bars"></i>
             </div>
             <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
           </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-xs-6">
           <!-- small box -->
           <div class="small-box bg-yellow">
             <div class="inner">
               <h3><?php echo $pending; ?></h3>

               <p>Pending Deliveries</p>
             </div>
             <div class="icon">
               <i class="ion ion-person-add"></i>
             </div>
             <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
           </div>
         </div>
         <!-- ./col -->
         <!-- <div class="col-lg-3 col-xs-6">

           <div class="small-box bg-red">
             <div class="inner">
               <h3>65</h3>

               <p>Unique Visitors</p>
             </div>
             <div class="icon">
               <i class="ion ion-pie-graph"></i>
             </div>
             <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
           </div>
         </div> -->
         <!-- ./col -->
     </div>

 </div>

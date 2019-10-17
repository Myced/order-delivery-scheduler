

<div class="wrap">
    <h3>
        Scheduled Deliveries for Yesterday
    </h3>
</div>

 <div class="content">



     <br>
     <div class="row">
         <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Order List
                    </h3>
                </div>
            <!-- /.box-header -->
                <div class="box-body">

                    <div class="table-responsive">

                        <table class="table-bordered table datatable">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Order No</th>
                                    <th>Client</th>
                                    <th>Telephone</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Due Date</th>
                                    <th>Ville</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $count = 1; $total = 0; $realTotal = 0; ?>
                                <?php foreach ($orders as $order): ?>
                                    <?php
                                    $amount = $order->total - $order->shipping;


                                    //now get data for the ville
                                    if($order->order_data != null)
                                    {
                                        $order_data = unserialize($order->order_data);

                                        $region = $order_data['gt_region'];
                                        $seller = $order_data['gt_seller'];
                                        $town = isset($order_data['gt_town']) ? $order_data['gt_town'] : '-1';

                                        //get the seller name
                                        // and town name
                                        $sellerTerm = get_term_by("id", $seller, "seller");
                                        $townTerm = get_term_by("id", $town, "zone_town");


                                    }
                                     ?>
                                    <tr>
                                        <td> <?php echo $count++; ?> </td>
                                        <td> <?php echo date("d, M Y", strtotime($order->post_date)); ?> </td>
                                        <td> Ord #<?php echo $order->ID; ?> </td>
                                        <td> <?php echo $order->first_name . ' ' . $order->last_name; ?> </td>
                                        <td> <?php echo $order->tel; ?> </td>
                                        <td> <?php echo self::showStatus($order->post_status); ?> </td>
                                        <td> <?php echo number_format($amount) . ' FCFA'; ?> </td>
                                        <td>
                                            <div class="label label-danger">
                                                YESTERDAY
                                            </div>
                                        </td>
                                        <td> <?php if($order->order_data != null) { if($town != '-1') echo $townTerm->name; } ?> </td>
                                        <td>
                                            <a href="post.php?post=<?php echo $order->ID; ?>&action=edit"
                                                    class="btn btn-info btn-xs"
                                                    target="_blank">
                                                View
                                            </a>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>

                    </div>


                </div>
            <!-- /.box-body -->
            </div>
         </div>
     </div>

 </div>

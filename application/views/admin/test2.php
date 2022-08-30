<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">


        <!-- Page Heading -->
        <h5 class="h5 mb-1 text-gray-600"><?= $title; ?> ADMIN TESTING </h5>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- data dashboard -->
    <?php foreach ($tka as $total_tka); ?>
    <?php foreach ($pmib as $total_pmib); ?>
    <?php foreach ($cpmi as $total_cpmi); ?>
    <?php foreach ($phk as $total_phk); ?>


            <!-- start -->
            <p style="font-weight:bold; font-family:roboto; padding-left:5px;">Drawer Map</p>
           
            <div class="row">
                <div class="col-8">
                     <div id="mapcluster"></div>
                </div>
                <div class="col-4">
                    <label for="drawer">Data GeoJson Drawer</label>
                    <textarea id="drawerid" name="drawer" rows="17" cols="50" class="form-control"></textarea>
                </div>
                
            </div>
           
            <!-- end -->
    
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
</div>
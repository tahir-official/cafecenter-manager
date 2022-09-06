<?php
   include_once('include/header.php');
  
?>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
       <?php
        if (isset($_SESSION['message'])){ echo $_SESSION['message'];  unset($_SESSION['message']);}
        ?>
        <div id="alert"></div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Wallet Management</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=$portal_detail->MANAGER_PORTAL_URL?>">Home</a></li>
              <li class="breadcrumb-item active">Wallet Management</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Wallet</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Total Wallet Amount</label>
                <input type="text" id="total_wallet_amount" class="form-control" disabled value="<?=$portal_detail->CURRENCY.''.$manager_data->wallet?>">
              </div>
              <div class="form-group">
              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
              </div>
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Withdrawal Request</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <form class="form-horizontal" name="withdrawalRequst_form" id="withdrawalRequst_form" method="post" >
              <div class="card-body">
              <div id="alert_withdrawalRequst_detail"></div>
              <input type="hidden" name="action" value="withdrawalRequst" >
              
                <div class="form-group">
                    <label for="request_amount">Please Enter Withdrawal Amount</label>
                    <input type="number" id="request_amount" name="request_amount" class="form-control" value="" step="1">
                    
                </div>
                <div class="form-group">
                    <label for="bank_upi">Select Withdrawal Method</label>
                    <select class="form-control"  name="bank_upi" id="bank_upi" >
                      <option value="bank">Bank</option>
                      <option value="upi">UPI</option>
                      
                    </select>
                    
                    
                </div>
                
                <div class="form-group">
                  <button type="submit" id="withdrawalRequstBtn"  class="btn btn-success float-right" style="margin-top: 30px;">Submit</button>
                
                </div>
                
                
                
              </div>
            </form>
            <!-- /.card-body -->
          </div>
         
        </div>
      </div>
      <div class="row">
        <div class="col-12">
             <!-- /.card -->
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">All Transfer</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table">
                <thead>
                  <tr>
                    <th>File Name</th>
                    <th>File Size</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                  <tr>
                    <td>Functional-requirements.docx</td>
                    <td>49.8005 kb</td>
                    <td class="text-right py-0 align-middle">
                      <div class="btn-group btn-group-sm">
                        <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                      </div>
                    </td>
                  <tr>
                    <td>UAT.pdf</td>
                    <td>28.4883 kb</td>
                    <td class="text-right py-0 align-middle">
                      <div class="btn-group btn-group-sm">
                        <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                      </div>
                    </td>
                  <tr>
                    <td>Email-from-flatbal.mln</td>
                    <td>57.9003 kb</td>
                    <td class="text-right py-0 align-middle">
                      <div class="btn-group btn-group-sm">
                        <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                      </div>
                    </td>
                  <tr>
                    <td>Logo.png</td>
                    <td>50.5190 kb</td>
                    <td class="text-right py-0 align-middle">
                      <div class="btn-group btn-group-sm">
                        <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                      </div>
                    </td>
                  <tr>
                    <td>Contract-10_12_2014.docx</td>
                    <td>44.9715 kb</td>
                    <td class="text-right py-0 align-middle">
                      <div class="btn-group btn-group-sm">
                        <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                      </div>
                    </td>

                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </section>
    <!-- /.content -->


  </div>  
<?php
   include_once('include/footer.php');
?>
<?php
if($usertype_id == Configure::read('ROUSERTTYPE')){
?>
<div style="position:absolute;right:10px;top:5px;">
    <?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> Add New Voucher Fa',array('controller'=>'Vouchersfas','action'=>'add'),array('escape'=>false,'class'=>'btn btn-success btn-sm'))?>
</div>
<?php
}
?>
<div class="box-body">
    <div>
        <?php echo $this->Form->create('SearchForm',array('id'=>'searchForm','method'=>'POST'));?>
        <table class="table">
<?php
if($usertype_id != Configure::read('ROUSERTTYPE')){
?>        
            <tr>
                <td width="50%">
                    <?php echo $this->Form->input('dfo_id',array('type'=>'select','label'=>'DFO','id'=>'dfo_id','options'=>$dfoList,'class'=>'form-control','div'=>false))?>
                </td>  
                <td id="rotdId">
                    <?php echo $this->Form->input('ro_id',array('type'=>'select','label'=>'Range Officer','id'=>'ro_id','options'=>$roList,'class'=>'form-control','div'=>false))?>
                </td>
            </tr>
<?php
}
?>            
            <tr>
                <td width="50%">
                    <?php echo $this->Form->input('fyear',array('type'=>'select','label'=>'Financial Year','id'=>'fyear','options'=>$fyear,'class'=>'form-control','div'=>false))?>
                </td>  
                <td id="rotdId">
                    <?php echo $this->Form->input('account_id',array('type'=>'select','label'=>'Head of Service','id'=>'account_id','options'=>$hos,'empty'=>'--All--','class'=>'form-control','div'=>false))?>
                </td>
            </tr>             
            <tr>
                <td>
                    <?php echo $this->Form->input('start_date',array('type'=>'text','label'=>'Start Date','id'=>'start_date','class'=>'form-control','div'=>false,'readonly'=>true))?>
                </td>  
                <td id="rotdId">
                    <?php echo $this->Form->input('end_date',array('type'=>'text','label'=>'End Date','id'=>'end_date','class'=>'form-control','div'=>false,'readonly'=>true))?>
                </td>
            </tr>            
            <tr>
                <td>
                    <?php echo $this->Form->input('voucher_status',array('type'=>'select','label'=>'Status','id'=>'voucher_status','class'=>'form-control','div'=>false,'options'=>array('P'=>'Pending','A'=>'Approved','R'=>'Rejected'),'empty'=>'--All--'))?>
                </td>
                <td></td>                
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <?php echo $this->Form->button('Search',array('type'=>'button','class'=>'btn btn-success','div'=>false,'label'=>false,'onclick'=>'javascript:showData();'))?>
                    <?php echo $this->Form->button('Reset',array('type'=>'reset','class'=>'btn btn-warning','div'=>false,'label'=>false))?>
                </td>
            </tr>
        </table>
        <?php echo $this->Form->end();?>
    </div>
    <div id="listingDiv">
        
    </div>
</div>
<script>
$(document).ready(function(){
    showData();
    $('#dfo_id').change(function(){
        var url = "<?php echo $this->Html->url(array('controller'=>'Common','action'=>'getRo'))?>";
        $.post(url,{'dfo_id':$('#dfo_id').val()},function(res){
            $('#rotdId').html(res);
        });
    });
});
function showData(){
    $('#lodding_image').show();
    var url = "<?php echo $this->Html->url(array('controller'=>'Vouchersfas','action'=>'indexAjax'))?>";
    url = url+'/ro_id:'+$('#ro_id').val();
    url = url+'/dfo_id:'+$('#dfo_id').val();  
    url = url+'/fyear:'+$('#fyear').val();
    url = url+'/account_id:'+$('#account_id').val();
    url = url+'/start_date:'+$('#start_date').val();
    url = url+'/end_date:'+$('#end_date').val();
    url = url+'/voucher_status:'+$('#voucher_status').val();
    url = url+'/page:'+$('#page').val();
    $.post(url,{},function(res){ 
        $('#listingDiv').html(res);
        $('#lodding_image').hide();
    });     
}
function approveVoucherfas(voucherfasId){
    if(voucherfasId != ''){
        if(confirm('Are you sure to approve?')){
            var url = "<?php echo $this->Html->url(array('controller'=>'Vouchersfas','action'=>'voucherfasApprove'))?>";
            $.post(url,{id:voucherfasId},function(res){ 
                if(res.trim() == 'SUCC'){
                    $('#td'+voucherfasId).html('<span style="color:green;font-weight:bold;">Approved Successfully</span>');
                }
            }); 
        }
    }    
}
function rejectVoucherfas(voucherfasId){
    if(voucherfasId != ''){
        var remarks=prompt("Enter Remarks");
        if(remarks){          
            if(confirm('Are you sure to reject?')){
                var url = "<?php echo $this->Html->url(array('controller'=>'Vouchersfas','action'=>'voucherfasReject'))?>";
                $.post(url,{id:voucherfasId,'remarks':remarks},function(res){ 
                    if(res.trim() == 'SUCC'){
                        $('#td'+voucherfasId).html('<span style="color:red;font-weight:bold;">Rejected Successfully</span>');
                    }
                }); 
            }
        }
    }   
}
function deleteVoucherfa(vouchersfaId){
    if(vouchersfaId != ''){
        if(confirm('Are you sure to delete?')){
            var url = "<?php echo $this->Html->url(array('controller'=>'Vouchersfas','action'=>'voucherfaDelete'))?>";
            $.post(url,{id:vouchersfaId},function(res){ 
                if(res.trim() == 'SUCC'){
                    showData();
                }
            }); 
        }
    }    
}
function printfunc(){
    var printContents = document.getElementById("print_div").innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
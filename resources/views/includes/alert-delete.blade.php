swal({
title     :"Are you sure?",
text      :"Once deleted, you will not be able to recover this imaginary file!",
icon      :"warning",
buttons   :true,
dangerMode:true,
})
.then((willDelete) => {
if(willDelete){
swal("Poof! Your imaginary file has been deleted!", {
icon:"success",
});
$.ajax({
url    :url,
type   :'DELETE',
data   :{'csrf_token':token},
success:function(result){
swal(
'Đã xóa!',
'Dữ liệu đã được xóa.',
'success'
)
datatables.ajax.reload();
}
});
} else {
swal("Lệnh đã được hủy")
;
}
})
;
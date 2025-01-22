function getURLParams(){var e=document.URL.indexOf("?"),a=new Array;if(-1!=e)for(var n=document.URL.substring(e+1,document.URL.length).split("&"),t=0;t<n.length;t++)nameVal=n[t].split("="),0==t&&$('input[name="v"]').val(nameVal[1]),a[nameVal[0]]=nameVal[1];return a}$(document).ready(function(){params=getURLParams()}),$(document).on("submit","#registration_form",function(e){e.preventDefault();var a=$("#firstName").val(),n=$("#lastName").val(),t=$("#address").val(),i=$("#mobileNum").val(),o=$("#temperature").val(),s=$("#purpose").val(),r=$("#v").val();$.ajax({url:"./library/api.php",method:"POST",data:JSON.stringify({action:"new_logs",v:r,image_fn:"",id_fn:"",lastname:n,firstname:a,address:t,mobile_no:i,temperature:o,purpose:s}),contentType:"application/json; charset=utf-8",dataType:"json",success:function(e){0!=e[0].log_id?iziToast.success({title:"Success",timeout:1e3,message:"Thank You For Your Registering!",pauseOnHover:!0,position:"topCenter",animateInside:!0,onClosing:function(){window.location.href="index.html?v="+r}}):iziToast.error({title:"Error",message:response_desc,pauseOnHover:!0,position:"topCenter",animateInside:!0})}})});
function currency(param){
    param = typeof param === 'string' ? parseFloat(param) : param;
    param = param.toFixed(2);
    param = param.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    param = `₱ ${param}`;
    return param;
}
function dateFormat(param){
    const date = typeof param != 'undefined' ? new Date(param) : new Date();
    const obj = {
        year: date.getFullYear(),
        month_og: date.getMinutes(),
        month: (date.getMonth() + 1),
        day: date.getDate(),
        hour: date.getHours(),
        minutes: date.getMinutes(),
        seconds: date.getSeconds(),
        median: date.getHours() >= 12 ? "PM" : 'AM',
        hour_median: date.getHours() >= 12 ? (date.getHours() - 12) : date.getHours()
    }

    const parseValue = ['month','day','hour','minutes','seconds','hour_median'];
    if(parseValue.length){
        for(let i in parseValue){
            const value = parseValue[i];
            if(typeof obj[value] != 'undefined'){
                if(obj[value] < 9){
                    obj[value] = `0${obj[value]}`
                }
            }
        }
    }
    return obj;
}
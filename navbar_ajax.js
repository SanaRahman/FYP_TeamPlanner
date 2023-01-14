msg=document.querySelector("#msg");
message_alert=document.querySelector("#message_alert");
msg_count=document.querySelector("#msg_count");

alert=document.querySelector("#alert");
alert_show=document.querySelector("#alert_show");
alert_count=document.querySelector("#alert_count");

msg.onclick=()=>{
  const xhr=new XMLHttpRequest();
  xhr.open("POST","././php_backend/notifications_show.php",true);
  xhr.onload=()=>{
    if(xhr.readyState===4 && xhr.status===200){
       let data=xhr.response;
    message_alert.innerHTML=data;
    }
  }
xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xhr.send("message=message");
}

alert.onclick=()=>{
  const xhr=new XMLHttpRequest();
  xhr.open("POST","././php_backend/notifications_show.php",true);
  xhr.onload=()=>{
    if(xhr.readyState===4 && xhr.status===200){
       let data=xhr.response;
    alert_show.innerHTML=data;
    }
  }
xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xhr.send("alert=alert");
}

setInterval(()=>{
const xhr=new XMLHttpRequest();
xhr.open("POST","././php_backend/notifications_show.php",true);
xhr.onload=()=>{
  if(xhr.readyState===4 && xhr.status===200){
     let data=xhr.response;
  alert_count.innerHTML=data;
  }
}
xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xhr.send("alert_count=alert_count");
},1000);

setInterval(()=>{
const xhr=new XMLHttpRequest();
xhr.open("POST","././php_backend/notifications_show.php",true);
xhr.onload=()=>{
  if(xhr.readyState===4 && xhr.status===200){
     let data=xhr.response;
  msg_count.innerHTML=data;
  }
}
xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xhr.send("msg_count=msg_count");
},1000);

$(document).ready(function(){
  $(".profile .icon_wrap").click(function(){
    $(this).parent().toggleClass("active");
    $(".notifications").removeClass("active");
  });

  $(".notifications .icon_wrap").click(function(){

    $(this).parent().toggleClass("active");
     $(".profile").removeClass("active");
  });
});




const form=document.querySelector("#sub"),
btn=form.querySelector("#s"),
error=form.querySelector(".error-text");
const f=document.querySelector(".typing-area"),
btnsend=f.querySelector("button"),
chatbox=document.querySelector(".chat-box"),
input=f.querySelector(".input-field");


f.onsubmit=(e)=>{
  e.preventDefault();
}



 $('.show_data').click(function(){
  console.log("button");
  var employee_id = $(this).attr("id");
  $.ajax({
    url:"././php_backend/delete_member.php",
    method:"post",
  data:{employee_id:employee_id},
    success:function(data){
    $('#employee_detail').html(data);
    $('#member_info').modal("show");
      }
  });
});



btn.onclick=()=>{
const xhr=new XMLHttpRequest();
xhr.open("POST","././php_backend/view_project.php",true);
xhr.onload= ()=>{
  if(xhr.readyState===4){
    if(xhr.status===200){
  let data=xhr.response;
  if(data=="success"){
    start_load()
   alert_toast('sucessfully submitted',"success");
        setTimeout(function(){
          window.location.href = 'index.php?page=view_project';

        },1000)
  }
  else{
   error.style.display = "block";
   error.textContent=data;}
    }
  }
}
let formdata=new FormData(form);
formdata.append("submit_task","submit_task");
formdata.append("type","<?php echo $type; ?>");
xhr.send(formdata);
}


//------------------chat--------------
btnsend.onclick=()=>{
  const xhr=new XMLHttpRequest();
  xhr.open("POST","././php_backend/view_project.php",true);
  xhr.onload=()=>{
    if(xhr.readyState===4 && xhr.status===200){
  input.value="";
   scrollToBottom();
    }
  }
  let formdata=new FormData(f);
  formdata.append("send","send");
  xhr.send(formdata);
}

setInterval(()=>{
  const xhr=new XMLHttpRequest();
  xhr.open("POST","././php_backend/view_project.php",true);
  xhr.onload=()=>{
    if(xhr.readyState===4 && xhr.status===200){
     chatbox.innerHTML=xhr.response;
     data=xhr.response;
     if(!chatbox.classList.contains("active")){
               scrollToBottom();
             }
           }}
  let formdata=new FormData(f);
  formdata.append("show_chat","show");
  xhr.send(formdata);
},300);



input.focus();
input.onkeyup = ()=>{
    if(input.value != ""){
      btnsend.classList.add("active");
    }else{
        btnsend.classList.remove("active");
    }
}

function scrollToBottom(){
    chatbox.scrollTop = chatbox.scrollHeight;
  }

  chatbox.onmouseenter = ()=>{
      chatbox.classList.add("active");
  }

  chatbox.onmouseleave = ()=>{
      chatbox.classList.remove("active");
  }
  function openchat(){
    document.getElementById("chat").style.display = "block";
  }

  function closechat() {
    document.getElementById("chat").style.display = "none";
  }

  $('.delete_task').click(function(){
  	_conf("Are you sure to delete this task?","delete_task",[$(this).attr('data-id')])
  	})
  	function delete_task($id){
  		start_load()
  		$.ajax({
  			url:'././php_backend/delete.php?delete_task=1',
  			method:'POST',
  			data:{id:$id},
  			success:function(resp){
  				if(resp==1){
  					alert_toast("Data successfully deleted",'success')
  					setTimeout(function(){
  						location.reload()
  					},1500)

  				}else{console.log(resp);}
  			}
  		})
  	}

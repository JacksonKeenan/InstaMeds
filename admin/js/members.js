function approve_member(index){
  console.log(index);
  $.ajax({
      type:'POST',
      url:'includes/approveMember.inc.php',
      data: {index: index}
    });
    setTimeout(function(){ location.reload(); }, 500);
}

function decline_member(index){
  console.log(index);
  $.ajax({
      type:'POST',
      url:'includes/declineMember.inc.php',
      data: {index: index}
    });
    setTimeout(function(){ location.reload(); }, 500);
}

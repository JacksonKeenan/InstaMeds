function remove_item(index){
  console.log(index);
  $.ajax({
      type:'POST',
      name:'remove-item',
      url:'includes/removeItem.inc.php',
      data: {index: index}
    });
    setTimeout(function(){ location.reload(); }, 500);
}

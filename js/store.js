function launch_toast(name, quantity, price, div) {
    var x = document.getElementById(div);
    console.log(x.className);
    x.className = "toast ToastShow";
    setTimeout(function(){ x.className = x.className.replace("ToastShow", ""); }, 5000);

    $.ajax({
        type:'POST',
        url:'includes/store.inc.php',
        data: { name: name, quantity: quantity, price: price},
      });

}

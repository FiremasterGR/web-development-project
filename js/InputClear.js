function InputClear(event){
  event.preventDefault();
  lightbox.style.display="flex";
  document.getElementById("lightbox-alert").style.display="flex";
}
function ClearAll(){
  document.querySelectorAll('input').forEach(input => {
    if (input.type == 'checkbox' || input.type == 'radio') {
      input.checked = false;
      input.dispatchEvent(new Event("change"));
      window.deleteradios?.(input.name);
    }
    else {
      input.value = '';
      input.dispatchEvent(new Event("input"));
      window.deletevalues?.(input.id);
    }
  });
  if (document.getElementById("previewcontainer")){
    for (var i=1; i<num; i++){
      document.getElementById("imgcontainer"+i).remove();
    }   
    num=1;
  }
  window.deleteimage?.("all");
  lightbox.style.display='none';
}
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Sortable - Default functionality</title>
  <script src="javascripts/jquery-1.10.2.js"></script>
  <script src="javascripts/jquery-ui.js"></script>
 
  <script>
  $(function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  });
  </script>
</head>
<body>
 
<ul id="sortable">
  <li class="ui-state-default" id="1"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 1</li>
  <li class="ui-state-default" id="2"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>
  <li class="ui-state-default" id="3"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>
  <li class="ui-state-default" id="4"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 4</li>
  <li class="ui-state-default" id="5"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>
  <li class="ui-state-default" id="6"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 6</li>
  <li class="ui-state-default" id="7"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 7</li>
</ul>
<p id="demo">

</p>
<script>
  var items = [];
  $('#sortable .ui-state-default').each(function (i, e) {
  items.push($(e).text());
  document.getElementById("demo").innerHTML+=e.getAttribute('id');
  document.getElementById("demo").innerHTML+="<br \>";
});
var obj = {
    name: 'subject_choice',
    value: items[];
};

localStorage.setItem('sub_choice', JSON.stringify(obj));
</script>
</body>
</html>
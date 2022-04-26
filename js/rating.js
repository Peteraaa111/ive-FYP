function submitrestaurantrating(id) {
  var ckInfo = CKEDITOR.instances.chatbox.getData();
  var reviewtitle = $('#reviewtitle').val();
  var mealtime = $('#mealstime').val();
  var type_of_meal = $("input[name='type_of_meal']:checked").val();
  var choice1 = $('#choice1').val();
  var choice2 = $('#choice2').val();
  var choice3 = $('#choice3').val();
  var choice4 = $('#choice4').val();
  if (reviewtitle==""){
    alert("食評標題不能為空白");
  }else if (mealtime==""){
    alert("用餐日期不能為空白");
  }else if (type_of_meal==null){
    alert("用餐途徑不能為空白");
  }else if(ckInfo==""){
    alert("内容不能為空白");
  }else if (choice1==""){
    alert("味道評分不能為空白");
  }else if (choice2==""){
    alert("環境評分不能為空白");
  }else if (choice3==""){
    alert("服務評分不能為空白");
  }else if (choice4==""){
    alert("衛生評分不能為空白");
  }else{
    $.ajax({
      url: "/function.php?op=restaurantRatingSubmit&id="+id,
      method: "POST",
      dataType: "json",
      data: {ckInfo11: ckInfo, reviewtitle: reviewtitle, mealtime: mealtime, type_of_meal: type_of_meal, choice1: choice1, choice2: choice2, choice3: choice3, choice4: choice4, },
      success: function (res) {
        if (res.success === true) {
          alert("食評已提交");
          window.location = 'r_details.php?id='+id;
        } else {
          console.log(res.reason);
        }
      },
      error: function (res) {
        alert(res.responseText);
      },
    });
  }
}

function submitattractionrating(id) {
  var ckInfo = CKEDITOR.instances.chatbox.getData();
  var reviewtitle = $('#reviewtitle').val();
  var mealtime = $('#mealstime').val();
  var choice2 = $('#choice2').val();
  var choice3 = $('#choice3').val();
  var choice4 = $('#choice4').val();
  if (reviewtitle==""){
    alert("評分標題不能為空白");
  }else if (mealtime==""){
    alert("遊覽日期不能為空白");
  }else if(ckInfo==""){
    alert("内容不能為空白");
  }else if (choice2==""){
    alert("環境評分不能為空白");
  }else if (choice3==""){
    alert("服務評分不能為空白");
  }else if (choice4==""){
    alert("衛生評分不能為空白");
  }else{
    $.ajax({
      url: "/function.php?op=attractionRatingSubmit&id="+id,
      method: "POST",
      dataType: "json",
      data: {ckInfo11: ckInfo, reviewtitle: reviewtitle, mealtime: mealtime, choice2: choice2, choice3: choice3, choice4: choice4, },
      success: function (res) {
        if (res.success === true) {
          alert("評分已提交");
          window.location = 'a_details.php?id='+id;
        } else {
          console.log(res.reason);
        }
      },
      error: function (res) {
        alert(res.responseText);
      },
    });
  }

}

function submitguesthouserating(id) {
  var ckInfo = CKEDITOR.instances.chatbox.getData();
  var reviewtitle = $('#reviewtitle').val();
  var mealtime = $('#mealstime').val();
  var type_of_meal = $("input[name='type_of_meal']:checked").val();
  var choice1 = $('#choice1').val();
  var choice2 = $('#choice2').val();
  var choice3 = $('#choice3').val();
  var choice4 = $('#choice4').val();
  if (reviewtitle==""){
    alert("評價標題不能為空白");
  }else if (mealtime==""){
    alert("入住日期不能為空白");
  }else if (type_of_meal==null){
    alert("入住時間不能為空白");
  }else if(ckInfo==""){
    alert("内容不能為空白");
  }else if (choice1==""){
    alert("舒適評分不能為空白");
  }else if (choice2==""){
    alert("環境評分不能為空白");
  }else if (choice3==""){
    alert("服務評分不能為空白");
  }else if (choice4==""){
    alert("衛生評分不能為空白");
  }else{
    $.ajax({
      url: "/function.php?op=guesthouseRatingSubmit&id="+id,
      method: "POST",
      dataType: "json",
      data: {ckInfo11: ckInfo, reviewtitle: reviewtitle, mealtime: mealtime, type_of_meal: type_of_meal, choice1: choice1, choice2: choice2, choice3: choice3, choice4: choice4, },
      success: function (res) {
        if (res.success === true) {
          alert("評價已提交");
          window.location = 'g_details.php?id='+id;
        } else {
          console.log(res.reason);
        }
      },
      error: function (res) {
        alert(res.responseText);
      },
    });
  }
}
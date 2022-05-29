$(function () {
  /*タイトルをクリックすると*/
  $(".question_box").on("click", function() {
    /*クリックした隣の要素を開閉する*/
    $(this).next().slideToggle(300);
    /*タイトルにopenクラスの追加、削除を行って矢印の向きを変える*/
    $(this).toggleClass("open",300);
  });
});

for (let index = 0; index < array.length; index++) {
  const element = array[index];
  
}


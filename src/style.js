/* 
 比較チェックボタンついた会社を一時表示するボックスの関数
*/
//各チェックボックスを取得
   let compare_checked_buttons = document.getElementsByName("select_company_checkboxes");
//各チェックボックスが選択されたら呼び出される関数
   function checked_counter(){
     //選択された会社の情報を入れるための配列
        let box_contents = []; 
     //表示箇所を取得
        let checked_company_box = document.getElementById("checked_company_box")
     //チェックボックスごとに、選択されているかどうかで文字列用の配列に出し入れを行う
        for(let i = 0; i < compare_checked_buttons.length; i++){
          if(compare_checked_buttons[i].checked){
            box_contents.push(compare_checked_buttons.item(i).value) 
          }
        } 
     //表示箇所に選択されている会社を表示
        checked_company_box.textContent = box_contents;
   }

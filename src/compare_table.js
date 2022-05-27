/* 
 比較チェックボタンついた会社を一時表示するボックスの関数
*/
//各チェックボックスを取得
let compare_checked_buttons = document.getElementsByName("select_company_checkboxes");
let compare_display_box = document.getElementById("at_once_box");
//各チェックボックスが選択されたら呼び出される関数
   function checked_counter(){
    compare_display_box.style = "display: block";
     //選択された会社の情報を入れるための配列
        let box_contents = []; 
     //選択された会社のidを入れるための配列
        // let company_ids = ""; 
     //表示箇所を取得
        let checked_company_box = document.getElementById("checked_company_box")
     //チェックボックスごとに、選択されているかどうかで文字列用の配列に出し入れを行う
        for(let i = 0; i < compare_checked_buttons.length; i++){
          let company_value = compare_checked_buttons.item(i).value;
          if(compare_checked_buttons[i].checked){
            box_contents.push(company_value);
          }
        } 
        // console.log(box_contents);

      //表示箇所に選択されている会社を表示
      let at_once_company_contents = '';
      box_contents.forEach(function(element){
        let split_company_id = element.replace(/[^0-9]/g, ''); //[^0-9]は数値以外という意味
        let split_company_name = element.replace(/[0-9]/g, ''); //[0-9]は数値という意味
        console.log(split_company_id);
        console.log(split_company_name);
        console.log(element);
        at_once_company_contents+=`<input type="checkbox" name="id[]" class="required" value="${split_company_id}" checked>${split_company_name}`
        // at_once_company_contents+=`<input type="checkbox" name="id[]" class="required" value="${split_company_id}" checked><label>${element}</label>`
        checked_company_box.innerHTML = at_once_company_contents;
      });
      
   }

  
    // for(let i = 0; i < compare_checked_buttons.length; i++){
    //   var checked_companies = document.getElementById(`checked_box_${i}`);
    //   }
    //   checked_companies.addEventListener(checked_counter);
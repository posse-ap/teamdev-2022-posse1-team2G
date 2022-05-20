//validationForm クラス と novalidate 属性を指定した form 要素を独自に検証
document.addEventListener('DOMContentLoaded', () => {
  //validationForm クラスを指定した最初の form 要素を取得
  const validationForm = document.getElementsByClassName('validationForm')[0];
  //初回送信前にはエラーを表示しない（送信時及び送信後にエラーがあればエラーを表示）
  let validateAfterFirstSubmit = true;
  //エラーを表示する span 要素に付与するクラス名
  const errorClassName = 'error-js';
  
  if(validationForm) {
    //required クラスを指定された要素の集まりを取得して変数に代入 
    const requiredElems = document.querySelectorAll('.required');
    //pattern クラスを指定された要素の集まりを取得して変数に代入 
    const patternElems =  document.querySelectorAll('.pattern');
    //maxlength クラスを指定された要素の集まりを取得して変数に代入 
    const maxlengthElems =  document.querySelectorAll('.maxlength');
 
    //エラーメッセージを表示する span 要素を生成して親要素に追加する関数
    //elem ：対象の要素
    //className ：エラーメッセージの要素に追加するクラス名
    //defaultMessage：デフォルトのエラーメッセージ
    const addError = (elem, className, defaultMessage) => {
      //戻り値として返す変数 errorMessage にデフォルトのエラーメッセージを代入
      let errorMessage = defaultMessage;
      //要素に data-error-xxxx 属性が指定されていれば（xxxx は第2引数の className）
      if(elem.hasAttribute('data-error-' + className)) { 
        //data-error-xxxx  属性の値を取得
        const dataError = elem.getAttribute('data-error-' + className);
        //data-error-xxxx  属性の値が label であれば
        if(dataError) {// data-error-xxxx  属性の値が label 以外の場合
          //data-error-xxxx  属性の値をエラーメッセージとする
          errorMessage = dataError;
        }
      }
      //初回の送信前にはエラー表示はせず、送信時及び送信後の再入力時にエラーを表示
      if(!validateAfterFirstSubmit) {
        //span 要素を生成
        const errorSpan = document.createElement('span');
        //error 及び引数に指定されたクラスを追加（設定）
        errorSpan.classList.add(errorClassName, className);
        //aria-live 属性を設定
        errorSpan.setAttribute('aria-live', 'polite');
        //引数に指定されたエラーメッセージを設定
        errorSpan.textContent = errorMessage;
        //elem の親要素の子要素として追加
        elem.parentNode.appendChild(errorSpan);
      }
    }
 
    //値が空かどうかを検証及びエラーを表示する関数（空の場合は true を返す）
    //elem ：対象の要素
    const isValueMissing = (elem) => {
      //ラジオボタンの場合
      if(elem.tagName === 'INPUT' && elem.getAttribute('type') === 'radio') {
        //エラーメッセージの要素に追加するクラス名（data-error-xxxx の xxxx）
        const className = 'required-radio';
        //エラーを表示する span 要素がすでに存在すれば取得（存在しなければ null が返る）
        const errorSpan = elem.parentElement.querySelector('.' + errorClassName + '.' + className);
        //選択状態の最初のラジオボタン要素を取得
        const checkedRadio = elem.parentElement.querySelector('input[type="radio"]:checked');
        //選択状態のラジオボタン要素を取得できない場合
        if(checkedRadio === null) {
         if(!errorSpan) {
           //addError() を使ってエラーメッセージ表示する span 要素を生成して追加
            addError(elem, className, '選択は必須です');
          }
          return true;
        } else{ //いずれかのラジオボタンが選択されている場合
          //エラーメッセージ表示する span 要素がすでに存在すれば削除してエラーをクリア
          if(errorSpan) {
            elem.parentNode.removeChild(errorSpan);
          }
          return false;
        } 
      }else if(elem.tagName === 'INPUT' && elem.getAttribute('type') === 'checkbox') {
        //チェックボックスの場合
        const className = 'required-checkbox';
        const errorSpan = elem.parentElement.querySelector('.' + errorClassName + '.' + className);
        //選択状態の最初のチェックボックス要素を取得
        const checkedCheckbox = elem.parentElement.querySelector('input[type="checkbox"]:checked');
        if(checkedCheckbox === null) {
          if(!errorSpan) {
            addError(elem, className, '選択は必須です');
          }
          return true;
        }else{
          if(errorSpan) {
            elem.parentNode.removeChild(errorSpan);
          }
          return false;
        }
      }else{
        //テキストフィールドやテキストエリア、セレクトボックスの場合
        const className = 'required';
        const errorSpan = elem.parentElement.querySelector('.' + errorClassName + '.' + className);
        //値が空の場合はエラーを表示して true を返す（trim() で前後の空白文字を削除）
        if(elem.value.trim().length === 0) {
          if(!errorSpan) {
            if(elem.tagName === 'SELECT') {
              //セレクトボックスの場合
              addError(elem, className, '選択は必須です');
            }else{ 
              //テキストフィールドやテキストエリアの場合
              addError(elem, className, '入力は必須です');
            } 
          }
          return true;
        }else{
          if(errorSpan) {
            elem.parentNode.removeChild(errorSpan);
          }
          return false;
        }
      }
    }
 
    //required クラスを指定された要素に input イベントを設定（値が変更される都度に検証）
    requiredElems.forEach( (elem) => {
      //ラジオボタンまたはチェックボックスの場合
      if(elem.tagName === 'INPUT' && (elem.getAttribute('type') === 'radio' || elem.getAttribute('type') === 'checkbox' )){
        //親要素を基点に全てのラジオボタンまたはチェックボックス要素を取得
        const elems = elem.parentElement.querySelectorAll(elem.tagName);
        //取得した全ての要素に change イベントを設定
        elems.forEach( (elemsChild) => {
          elemsChild.addEventListener('change', () => {
            //それぞれの要素の選択状態が変更されたら検証を実行
            isValueMissing(elemsChild);
          });
        });
      }else{
        elem.addEventListener('input', () => {
          //要素の値が変更されたら検証を実行
          isValueMissing(elem);
        });
      }
    });
 
    //指定されたパターンにマッチしているかを検証する関数（マッチしていない場合は true を返す）
    //elem ：対象の要素
    const isPatternMismatch = (elem) => {
      //検証対象のクラス名
      const className = 'pattern';
      //対象の（パターンが記述されている） data-xxxx 属性（data-pattern）
      const attributeName = 'data-' + className;
      //data-pattern 属性にパターンが指定されていればその値をパターンとする
      let pattern = new RegExp('^' + elem.getAttribute(attributeName) + '$');
      //data-pattern 属性の値が email の場合
      if(elem.getAttribute(attributeName) ==='email') {
        pattern = /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ui;
      }else if(elem.getAttribute(attributeName) ==='phone_number') { //data-pattern 属性の値が phone_number の場合
        pattern = /^\(?\d{2,5}\)?[-(\.\s]{0,2}\d{1,4}[-)\.\s]{0,2}\d{3,4}$/;
      }
      //エラーを表示する span 要素がすでに存在すれば取得
      const errorSpan = elem.parentElement.querySelector('.' + errorClassName + '.' + className);
      //対象の要素の値が空でなければパターンにマッチするかを検証
      if(elem.value.trim() !=='') {
        if(!pattern.test(elem.value)) {
          if(!errorSpan) {
            addError(elem, className, '入力された値が正しくないようです');
          }
          return true;
        }else{
          if(errorSpan) {
            elem.parentNode.removeChild(errorSpan);
          }
          return false;
        }
      }else if(elem.value ==='' && errorSpan) {
        elem.parentNode.removeChild(errorSpan);
      }
    }
 
    //pattern クラスを指定された要素に input イベントを設定（値が変更される都度に検証）
    patternElems.forEach( (elem) => {
      elem.addEventListener('input', () => {
        //要素の値が変更されたら検証を実行
        isPatternMismatch(elem);
      });
    });
 
    
    //サロゲートペアを考慮した文字数を返す関数
    const getValueLength = (value) => {
      return (value.match(/[\uD800-\uDBFF][\uDC00-\uDFFF]|[\s\S]/g) || []).length;
    }
  
    //指定された最大文字数を満たしているかを検証する関数（満たしていない場合は true を返す）
    const isTooLong = (elem) => {
      //対象のクラス名
      const className = 'maxlength';
      //対象の data-xxxx 属性の名前
      const attributeName = 'data-' + className;
      //data-maxlength 属性から最大文字数を取得
      const maxlength = elem.getAttribute(attributeName);
      //エラーを表示する span 要素がすでに存在すれば取得（存在しなければ null が返る）
      const errorSpan = elem.parentElement.querySelector('.' + errorClassName + '.' + className);
      if(elem.value !=='') {
        //サロゲートペアを考慮した文字数を取得
        const valueLength = getValueLength(elem.value);
        //値がdata-maxlengthで指定された最大文字数より大きい場合はエラーを表示してtrueを返す
        if(valueLength > maxlength) {
          if(!errorSpan) {
            addError(elem, className, maxlength + '文字以内で入力ください');
          }
          return true;
        }else{
          if(errorSpan) {
            elem.parentNode.removeChild(errorSpan);
          }
          return false;
        }
      }else if(elem.value ==='' && errorSpan) {
        elem.parentNode.removeChild(errorSpan);
      }
    }
 
    //maxlength クラスを指定された要素に input イベントを設定
    maxlengthElems.forEach( (elem) => {
      elem.addEventListener('input', () => {
        isTooLong(elem);
      });
    }); 
    
 
    //送信時の処理
    validationForm.addEventListener('submit', (e) => {
      validateAfterFirstSubmit = false;
      //必須の検証
      requiredElems.forEach( (elem) => {
        if(isValueMissing(elem)) {
          e.preventDefault();
        }
      });
      //パターンの検証
      patternElems.forEach( (elem) => {
        if(isPatternMismatch(elem)) {
          e.preventDefault();
        }
      });
      //.maxlength を指定した要素の検証
      maxlengthElems.forEach( (elem) => {
        if(isTooLong(elem)) {
          e.preventDefault();
        }
      });
      //.error の要素を取得
      const errorElem = document.querySelector('.' + errorClassName);
      if(errorElem) {
        const errorElemOffsetTop = errorElem.offsetTop;
        //エラーの要素の位置へスクロール
        window.scrollTo({
          top: errorElemOffsetTop - 40,
          //スムーススクロール
          behavior: 'smooth'
        });
      }
    });
  }
});
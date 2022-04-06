function CheckPassword(confirm) {
    //入力した値を取得
    const input1 = password.value;
    const input2 = confirm.value;
    //同じ値が入力されたかチェック
    if (input1 != input2) {
        confirm.setCustomValidity("入力したパスワードが一致しません");
    } else {
        confirm.setCustomValidity("");
    }
}
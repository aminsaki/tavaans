export const converDatePersian = (date) => {
    return new Date(date).toLocaleDateString('fa-IR')

}
export const DatePersianTime = (date) => {
    let dates = new Date(date).toLocaleDateString('fa-IR');
    let time = new Date(date).toLocaleTimeString('fa-IR');
    return  time +' '+ dates;
    // var dateTime = date.toLocaleDateString('fa-IR') + ' ' + date.toLocaleTimeString('fa-IR');
}




export function DateTimeFa(data) {
    const date = new Date(data);

    // فرمت تاریخ
    const formattedDate = new Intl.DateTimeFormat('fa-IR', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    }).format(date);

    // فرمت ساعت
    const formattedTime = new Intl.DateTimeFormat('fa-IR', {
        hour: '2-digit',
        minute: '2-digit'
    }).format(date);

    // بازگشت ابتدا تاریخ و سپس ساعت
    return `${formattedTime}   ${formattedDate} `;
}

export const checkExpiration = (expirationDate) => {
    const now = new Date();
    const expiresAt = new Date(expirationDate);
    return expiresAt > now;
};
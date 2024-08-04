class ParserDate {
    processDate(dateInfo) {
        const date = new Date(dateInfo);
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return day + "/" + month + "/" + year;
    }
}

export { ParserDate }
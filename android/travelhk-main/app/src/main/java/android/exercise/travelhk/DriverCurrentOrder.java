package android.exercise.travelhk;

public class DriverCurrentOrder {
    private String startAddress,endAddress,startDate,startTime,peopleNumber,bookingId,email,accountid,userName,userPhone;

    public DriverCurrentOrder(String startAddress, String endAddress, String startDate, String startTime, String peopleNumber, String bookingId, String email, String accountid, String userName, String userPhone) {
        this.startAddress = startAddress;
        this.endAddress = endAddress;
        this.startDate = startDate;
        this.startTime = startTime;
        this.peopleNumber = peopleNumber;
        this.bookingId = bookingId;
        this.email = email;
        this.accountid = accountid;
        this.userName = userName;
        this.userPhone = userPhone;
    }

    public String getStartAddress() {
        return startAddress;
    }

    public void setStartAddress(String startAddress) {
        this.startAddress = startAddress;
    }

    public String getEndAddress() {
        return endAddress;
    }

    public void setEndAddress(String endAddress) {
        this.endAddress = endAddress;
    }

    public String getStartDate() {
        return startDate;
    }

    public void setStartDate(String startDate) {
        this.startDate = startDate;
    }

    public String getStartTime() {
        return startTime;
    }

    public void setStartTime(String startTime) {
        this.startTime = startTime;
    }

    public String getPeopleNumber() {
        return peopleNumber;
    }

    public void setPeopleNumber(String peopleNumber) {
        this.peopleNumber = peopleNumber;
    }

    public String getBookingId() {
        return bookingId;
    }

    public void setBookingId(String bookingId) {
        this.bookingId = bookingId;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getAccountid() {
        return accountid;
    }

    public void setAccountid(String accountid) {
        this.accountid = accountid;
    }

    public String getUserName() {
        return userName;
    }

    public void setUserName(String userName) {
        this.userName = userName;
    }

    public String getUserPhone() {
        return userPhone;
    }

    public void setUserPhone(String userPhone) {
        this.userPhone = userPhone;
    }
}

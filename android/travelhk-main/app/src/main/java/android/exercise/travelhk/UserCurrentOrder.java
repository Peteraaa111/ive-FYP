package android.exercise.travelhk;

public class UserCurrentOrder {
    private String startAddress,endAddress,startDate,startTime,peopleNumber,bookingId,email,accountid,driverName,drivePhone;

    public UserCurrentOrder(String startAddress, String endAddress, String startDate, String startTime, String peopleNumber, String bookingId, String email, String accountid, String driverName, String drivePhone) {
        this.startAddress = startAddress;
        this.endAddress = endAddress;
        this.startDate = startDate;
        this.startTime = startTime;
        this.peopleNumber = peopleNumber;
        this.bookingId = bookingId;
        this.email = email;
        this.accountid = accountid;
        this.driverName = driverName;
        this.drivePhone = drivePhone;
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

    public String getDriverName() {
        return driverName;
    }

    public void setDriverName(String driverName) {
        this.driverName = driverName;
    }

    public String getDrivePhone() {
        return drivePhone;
    }

    public void setDrivePhone(String drivePhone) {
        this.drivePhone = drivePhone;
    }
}

const secretKey ="aDZ4bnEyYmd5aGc1Ng==";
const url = "https://recommendao4bnzpfw2axcws.azurewebsites.net/api/models/7901d5e3-bcbf-4673-8ab2-50be13929d62/recommend?";
const key = "X-API-Key:".secretKey;

function personalized(user_id, count) {
  var link = url + "userId=" + user_id + "&recommendationCount=" + count;
  
}
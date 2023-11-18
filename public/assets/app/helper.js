function threeDigitRound(value) {
  // threeDigitRound(110)  => 200
  if (value > 0) {
    value = Math.floor(value);
    let sValue = value.toString();
    let three_digit = parseFloat(sValue.substr(-3, 3));
    let remain_total = value - three_digit;
    let round_three_digit = Math.ceil(three_digit / 100) * 100;
    let new_value = remain_total + round_three_digit;
    return new_value;
  } else {
    return 0;
  }
}

function calcPercentRate(start_value, end_value) {
  // calcPercentRate(10000, 11000)  => 10
  if (start_value == 0 && end_value == 0) {
    return 0;
  }

  if (start_value == 0) {
    return 100;
  } else {
    let pr = ((end_value - start_value) / start_value) * 100;
    if (isNaN(pr)) {
      return 0;
    } else {
      return pr;
    }
  }
}

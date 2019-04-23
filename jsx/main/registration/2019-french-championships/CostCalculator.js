const JUNIOR = 'Junior';
const LADIES = 'Ladies';
const MASTERS = 'Masters';
const PRO = 'Pro';

export default (riders, costs) => {
  const total = riders.reduce((acc, rider) => {
    if (!rider.boardercross && !rider.freestyle) {
      return acc;
    }

    if (rider.category === JUNIOR) {
      if (rider.boardercross && rider.freestyle) {
        return acc + costs.kidTotal;
      } else {
        return acc + costs.kidEach;
      }
    } else {
      if (rider.boardercross && rider.freestyle) {
        return acc + costs.adultTotal;
      } else {
        return acc + costs.adultEach;
      }
    }
  }, 0);

  console.log({riders, costs, total});
  return total;
}
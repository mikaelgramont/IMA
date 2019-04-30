import { UNDER14 } from './Categories';

export default (riders, costs) => {
  const total = riders.reduce((acc, rider) => {
    if (!rider.boardercross && !rider.freestyle) {
      return acc;
    }

    if (rider.category === UNDER14) {
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

  return total;
}
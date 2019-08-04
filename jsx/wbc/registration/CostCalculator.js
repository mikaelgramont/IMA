export default (riders, costs) => {
  const total = riders.reduce((acc) => {
    return acc + costs.online;
  }, 0);

  return total;
}
export function subsets(input, size) {
    let results = [], result, mask, i, total = Math.pow(2, input.length);
    for (mask = size; mask < total; mask++) {
        result = [];
        i = input.length - 1;

        do {
            if ((mask & (1 << i)) !== 0) {
                result.push(input[i]);
            }
        } while (i--);

        if (result.length === size) {
            results.push(result);
        }
    }

    return results;
}

export function subsetsLineups(subset) {
    return [
        [subset[0], subset[1], subset[2], subset[3]],
        [subset[0], subset[2], subset[1], subset[3]],
        [subset[0], subset[3], subset[1], subset[2]],
    ]
}

export function shuffle(array) {
    let result = [...array];
    let currentIndex = result.length, temporaryValue, randomIndex;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        // And swap it with the current element.
        temporaryValue = result[currentIndex];
        result[currentIndex] = result[randomIndex];
        result[randomIndex] = temporaryValue;
    }

    return result;
}
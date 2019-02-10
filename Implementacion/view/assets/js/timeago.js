/**
 * Funciones necesarias para calcular los tiempos
 */
var templates = {
    prefix: LANG['prefix_ago'],
    suffix: LANG['suffix_ago'],
    seconds: LANG['less than a minute'],
    minute: LANG['about a minute'],
    minutes: " %d " + LANG['minutes'],
    hour: LANG["about an hour"],
    hours: LANG['about'] + " %d " + LANG['hours'],
    day: LANG["a day"],
    days: "%d " + LANG['days'],
    month: LANG["about a month"],
    months: "%d " + LANG['months'],
    year: LANG["about a year"],
    years: "%d " + LANG['years']
};
var template = function (t, n) {
    return templates[t] && templates[t].replace(/%d/i, Math.abs(Math.round(n)));
};

function time_ago(time) {
    if (!time)
        return;
    var t = time.split(/[- :]/);
    time = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));

    var now = new Date();
    var seconds = ((now.getTime() - time) * .001) >> 0;
    var minutes = seconds / 60;
    var hours = minutes / 60;
    var days = hours / 24;
    var years = days / 365;

    return templates.prefix + (
            seconds < 45 && template('seconds', seconds) ||
            seconds < 90 && template('minute', 1) ||
            minutes < 45 && template('minutes', minutes) ||
            minutes < 90 && template('hour', 1) ||
            hours < 24 && template('hours', hours) ||
            hours < 42 && template('day', 1) ||
            days < 30 && template('days', days) ||
            days < 45 && template('month', 1) ||
            days < 365 && template('months', days / 30) ||
            years < 1.5 && template('year', 1) ||
            template('years', years)
            ) + templates.suffix;
}
;

$(function() {
    $.vegas('slideshow', {
        backgrounds: [
            { src:'images/backgrounds/lol_01.jpg', fade:1000 },
            { src:'images/backgrounds/sc_01.jpg', fade:1000 }
        ]
    });
    $.vegas('overlay', {
        src:'images/backgrounds/overlay.png'
    });
});

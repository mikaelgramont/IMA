<style>
    .title-container {
        background: #D8D8D8;
        padding: 9px 9px;
        margin: 0 -9px 5px -9px;
    }

    .board-members-wrapper {
        overflow: hidden;
        margin-bottom: 10px;
    }

    .board-members-image {
        float: right;
        width: 240px;
        height: 240px;
        margin-left: 20px;
    }

    .board-members {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        flex-direction: column;
    }

    .board-member {
        display: flex;
        width: 100%;
        margin: 20px 0 0;
        padding: 10px 0;
    }

    .board-member:nth-child(even) {
        flex-direction: row-reverse;
    }

    .board-member-image {
        width: 240px;
        height: 240px;
    }

    .board-member .board-member-metadata {
        padding: 0 0 0 20px;
        flex: 1 0;
    }
    .board-member:nth-child(even) .board-member-metadata {
        padding: 0 20px 0 0;
    }

    @media screen and (max-width: 600px) {
        .board-members,
        .board-member {
            display: block;
        }
        .board-member-image,
        .board-members-image {
            float: none;
            display: block;
            margin: 0 auto;
        }
        .board-member:nth-child(even) {
            background: #D8D8D8;
        }
    }
    @media screen and (min-width: 800px) {
        .about-wrapper {
            display: flex;
            flex-direction: row-reverse;
        }

        .about-contact {
            margin-left: 40px;
            width: 300px;
        }
    }
</style>

<p class="paragraph">
    The IMA aims to push mountainboarding by supporting  event organizers, sponsors
    and the media.
</p>

<div class="about-wrapper">
    <div class="about-contact">
        <h1 class="display-font title-container">Get in touch</h1>
        <p class="paragraph">
            To get in touch with us, you can write to: <br>
            <a href="mailto:mountainboardworld@gmail.com">mountainboardworld@gmail.com</a>
        </p>
    </div>
    <div class="about-content">
        <h1 class="display-font title-container">A little history</h1>

        <p class="paragraph">
            The 2002 Morzine Mountainboard Fest was truly the first international mountainboarding competition.
            Set in the French Alps, it brought together riders from all over Europe, and started the first
            international efforts to coordinate the promotion of mountainboarding.
        </p>

        <p class="paragraph">
            After a few years of involvement in various events and communities, Diego Anderson started leading
            national clubs and associations towards a more professional side of the sport. In 2009, the
            International Mountainboard Association (IMA) was born and it took on efforts such as event
            regulation and standardization, and calendar coordination.
        </p>

        <p class="paragraph">
            Diego worked hard on the IMA, and after many years, decided to pass the responsibility on to someone
            else. In early 2016, a vote was held and long-time MBS rider Dave Stiefvater from Colorado (USA) was
            elected President of the IMA.
        </p>

        <h1 class="display-font title-container">Lately</h1>

        <div class="board-members-wrapper">
            <img class="board-members-image" src="<?php echo BASE_URL?>images/board-members.png" alt="" aria-label="Photo of the board" />

            <p class="paragraph">
                In early 2018, a new vote took place and Kody Stewart became President, working alongside Matt Brind (UK)
                and Mikael Gramont (France).</p>
            <p class="paragraph">
                You can see the <a href="<?php echo BASE_URL?>news/1-ima-elections">announcement for the elections here</a>,
                the <a href="<?php echo BASE_URL?>news/2-ima-presidential-candidates">presentation of the candidates who ran here</a>,
                and the <a href="<?php echo BASE_URL?>news/4-new-president-for-the-ima">election results here</a>.
            </p>
        </div>

        <h1 class="display-font title-container">The current IMA board</h1>

        <ul class="board-members">
            <li class="board-member">
                <img class="board-member-image" src="<?php echo BASE_URL?>images/board-member-kody.jpg" alt="" aria-label="Photo of Kody" />
                <div class="board-member-metadata">
                    <h2 class="">Kody Stewart - President</h2>
                    <p>BLA BLA BLA BLA BLA BLA BLA BLA BLA BLA </p>
                </div>
            </li>
            <li class="board-member">
                <img class="board-member-image" src="<?php echo BASE_URL?>images/board-member-matt.jpg" alt="" aria-label="Photo of Matt" />
                <div class="board-member-metadata">
                    <h2 class="">Matt Brind - Director of Operations</h2>
                    <p>BLA BLA BLA BLA BLA BLA BLA BLA BLA BLA </p>
                </div>
            </li>
            <li class="board-member">
                <img class="board-member-image" src="<?php echo BASE_URL?>images/board-member-mika.jpg" alt="" aria-label="Photo of Mikael" />
                <div class="board-member-metadata">
                    <h2 class="">Mikael Gramont - Treasurer</h2>
                    <p>BLA BLA BLA BLA BLA BLA BLA BLA BLA BLA </p>
                </div>
            </li>
        </ul>


    </div>
</div>

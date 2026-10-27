<?php
    # Program: fallacies.php
    #    Date: 30-Apr-2023
    #  Author: gerry.walterscheid@gmail.com
    # Descrip: Display types of logical fallacies and their meaning.

    session_start();
    header("Content-type: text/xml");

    $delay = 60;
    header("Refresh:$delay");

    $urlPath = "http://192.168.3.250/cisco/fallacies.php";

    $fallacy = array(
        "Ad Hominem", 
        "One that attempts to invalidate an opponent's position based on a personal trait or fact about the opponent rather than through logic.",
        "Katherine is a bad choice for mayor because she didn't grow up in this town.",

        "Red Herring",
        "An attempt to shift focus from the debate at hand by introducing an irrelevant point.", 
        "Losing a tooth can be scary, but have you heard about the Tooth Fairy?", 

        "Straw Man",
        "One that argues against an extreme, inaccurate version of the opposition rather than their actual argument.",
        "Erin thinks we need to stop using all plastics, right now, to save the planet from climate change.", 

        "Equivocation",
        "A statement crafted to mislead or confuse readers or listeners by using multiple meanings or interpretations of a word or simply through unclear phrasing.", 
        "While I have a clear plan for the campus budget that accounts for every dollar spent, my opponent simply wants to throw money at special interest projects.",

        "Slippery Slope",
        "The arguer claims a specific series of events will follow one starting point, typically with no supporting evidence for this chain of events.", 
        "If we make an exception for Joe's service dog, then other people will want to bring their dogs. Then everybody will bring their dog, and before you know it, our restaurant will be overrun with dogs and nobody will want to eat here anymore.",

        "Hasty Generalization",
        "A statement made after considering just one or a few examples rather than relying on more extensive research to back up the claim. The amount of research depends on the issue at hand and the statement being made about it.", 
        "I felt nauseated both times I ate pizza, so I must be allergic to something in pizza.",

        "Appeal to Authority",
        "The arguer claims an authority figure's expertise to support a claim despite this expertise being irrelevant or overstated.", 
        "If you want to be healthy, you need to stop drinking coffee. I read about it on the internet.",

        "False Dilemma",
        "Claims there are only two options in a given situation. Often, these two options are extreme opposites of each other, failing to acknowledge that other, more reasonable, options exist. This is also known as a false dichotomy.",
        "If you don't support my decision, you were never really my friend.", 

        "Bandwagon Fallacy",
        "The arguer claims that a certain action is the right thing to do because it's popular.", 
        "Of course it's fine to wait until the last minute to write your paper. Everybody does it!",

        "Appeal to Ignorance",
        "A claim that something must be true because it hasn't been proven false. It can also be a claim that something must be false because it hasn't been proven true. This is also known as the burden of proof fallacy.", 
        "There must be fairies living in our attic because nobody's ever proven that there aren't fairies living in our attic.",

        "Circular Argument",
        "One that uses the same statement as both the premise and the conclusion. No new information or justification is introduced.", 
        "Peppers are the easiest vegetable to grow because I think peppers are the easiest vegetable to grow.", 

        "Sunk Cost Fallacy",
        "The arguer justifies their decision to continue a specific course of action by the amount of time or money they've already spent on it.", 
        "I'm not enjoying this book, but I bought it, so I have to finish reading it.", 

        "Appeal to Pity",
        "Attempts to sway a reader's or listener's opinion by provoking them emotionally.", 
        "I know I should have been on time for the interview, but I woke up late and felt really bad about it, then the stress of being late made it hard to concentrate on driving here.",

        "Causal Fallacy",
        "One that implies a relationship between two things where one can't actually be proven.", 
        "When ice cream sales are up, so are shark attacks. Therefore, buying ice cream increases your risk of being bitten by a shark.", 

        "Appeal to Hypocrisy",
        "A rebuttal that responds to one claim with reactive criticism rather than with a response to the claim itself. This is also known as a tu quoque fallacy.",
        "You don't have enough experience to be the new leader. Neither do you!" ); 

    $count = 15;

    function FisherYatesIndex($n) {

        # Create array of n elements containing indexes.
        $arr = [];

        for ($i = 0; $i < $n; $i++)
            $arr[$i] = $i;

        # Perform index shuffle.
        for($i = $n - 1; $i > 0; $i--) {
            $r = rand(0, $i); $tmp = $arr[$i];
            $arr[$i] = $arr[$r];
            $arr[$r] = $tmp; }

        return $arr; }

    # Recall prior variable state
    $id = $_SESSION['id'] ?? "";                # Index pointing to item.

    # Prevent data corruption to next application.
    if ($id == "fallacies") {
        $lastCmd = $_SESSION['cmd'] ?? 0;       # User command.
        $mode = $_SESSION['mode'] ?? 0;         # Current mode.
        $ndx = $_SESSION['ndx'] ?? 0;           # Current index.
        $rndNdx = $_SESSION['rndNdx'] ?? 0;     # Random index.
        $update = $_SESSION['update'] ?? 0; }   # Time from prior page update.
    else {
        $mode = 0;
        $ndx = 0;
        $rndNdx = FisherYatesIndex($count); 
        $update = 0; }

    # Get SoftKey selection.
    $cmd = $_GET['key'] ?? 0;	                # User command.

    # Check page refresh delay.
	if (time() - $update < $delay)

        # Process user request based on the key pressed.	
        switch($cmd) {

        case 1 : # mode
            $mode = ++$mode % 3;
            break;

        case 2 : # previous
            if (--$ndx < 0)
                $ndx = $count - 1;

            $mode = 0;
            break;

        case 3 : # next
            if (++$ndx == $count)
                $ndx = 0;

            $mode = 0;
            break;
        }

    else {
        # Advance to next item after displaying answer.
        $ndx = ++$ndx % $count;
		$mode = 0; }

    # Update the indexes on both fields.
    $i = $rndNdx[$ndx] * 3;
	$j = $i + 1;
    $k = $i + 2;

    switch($mode) {

    case 0 : # Proverb
        echo "<CiscoIPPhoneText>\n";
        echo "  <Title>Logical Fallacies - Name</Title>\n";
        echo "  <Text>$fallacy[$i]</Text>\n";

        $msg = "";
        break;

    case 1 : # Explained
        echo "<CiscoIPPhoneText>\n";
        echo "  <Title>Logical Fallacies - Explaned</Title>\n";
        echo "  <Text>$fallacy[$j]</Text>\n";

        $msg = "Use arrows to view all text.";
        break;

	case 2 : # Example
        echo "<CiscoIPPhoneText>\n";
        echo "  <Title>Logical Fallacies - Example</Title>\n";
        echo "  <Text>$fallacy[$k]</Text>\n";

        $msg = "Use arrows to view all text.";
        break;
    }

    echo "  <SoftKeyItem>\n";
    echo "    <Name>More</Name>\n";
    echo "    <URL>$urlPath?key=1</URL>\n";
    echo "    <Position>1</Position>\n";
    echo "  </SoftKeyItem>\n";

    echo "  <SoftKeyItem>\n";
    echo "    <Name>Prev</Name>\n";
    echo "    <URL>$urlPath?key=2</URL>\n";
    echo "    <Position>2</Position>\n";
    echo "  </SoftKeyItem>\n";

    echo "  <SoftKeyItem>\n";
    echo "    <Name>Next</Name>\n";
    echo "    <URL>$urlPath?key=3</URL>\n";
    echo "    <Position>3</Position>\n";
    echo "  </SoftKeyItem>\n";

    echo "  <SoftKeyItem>\n";
    echo "    <Name>Exit</Name>\n";
    echo "    <URL>SoftKey:Exit</URL>\n";
    echo "    <Position>4</Position>\n";
    echo "  </SoftKeyItem>\n";

    echo "  <Prompt>$msg</Prompt>\n";
    echo "</CiscoIPPhoneText>";

    # Save current variable state.
    $_SESSION['id'] = "fallacies";
    $_SESSION['cmd'] = $cmd;
    $_SESSION['mode'] = $mode;
    $_SESSION['ndx'] = $ndx;
    $_SESSION['rndNdx'] = $rndNdx;
    $_SESSION['update'] = time();
?>

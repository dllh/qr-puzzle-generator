This is a script I wrote to turn a QR code into a grid with squares in two states, of which one state can be filled in to create the actual QR code. Seems weird, I know. The story is that I wanted to make a code for a scavenger hunt for somebody's birthday gift. First, I made the QR code using an online generator. Then I painstakingly used graphics software to draw slanty lines in a square grid such that if one printed it out and filled in the lines slanting up and to the right, the result would be the QR code.

Then the link I used in the QR code expired and all that work was lost. My heart sank. While I was carefully drawing those hundreds of tiny lines initially, I found myself thinking "I should have done this programattically." I thought so all the more when I hand-colored in the relevant squares with sharpie to test the thing out, and found that I had drawn some of the lines incorrectly.

Since I had the whole ugly thing to redo anyway, I sat down and wrote this little script to make it simpler. It's not exactly pretty. If I were feeling ambitious, I would have hooked into some QR code API and had it generated automatically; or I would've used some software that scanned in an image of the QR code and output the puzzle grid automatically. That was too ambitious for my quick need, so I made it so that using ones and zeroes in a grid format in the code, you could within a couple of minutes transcript a QR code into something that the script could use to output the puzzle to a png file.

As a bonus, I also made it so that the output could display either filled-in squares or the puzzle squares. This made validation easy, since I could toggle the script to print the filled-in values and scan with my phone to make sure I had set up my ones and zeroes correctly. Then, I just toggle back to print out the puzzle, and I'm done.
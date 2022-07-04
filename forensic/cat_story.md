# Write-up: it's not just a cat story

## Information sur le challenge:
- Description: We were able to recover during a tour at the house of the hacker usb keys, one of them is a real usb key and not a rubber ducky. Try to recover the information in this key
## Resolution:
- First of all, we can notice that the file that is given is not a simple .img file but an .e01 which corresponds to a forensic acquisition file. 
![image](https://user-images.githubusercontent.com/65206138/172379037-ab70a17a-cfc7-4eb4-ac0d-9a2ffa6c1f83.png)
- After several researches, to carry out our investigation, we can use the tool suite named "ewf-tool" for this acquisition.
![image](https://user-images.githubusercontent.com/65206138/172379880-df25fbcd-c63a-464e-9942-051a45a21189.png)
- Then, thanks to the given tools, we can extract the necessary information for our investigation like ewfinfo (to have information given by the usb key purchaser) and ewfmount (to get the disk image)
![image](https://user-images.githubusercontent.com/65206138/172380974-703a841b-4086-4904-9ea2-c93a308e9564.png) ![image](https://user-images.githubusercontent.com/65206138/172381234-e899bce1-e3b5-4fc3-b30c-79694300a51b.png)
- Now for hard disk investigation, we have either for the GUI part the tool we have FTK Imager or Autopsy. For the CLI tools we have an array But in this case we will use the tool suite The Sleuth Kit (the CLI version of autopsy).
- With [fls](http://www.sleuthkit.org/sleuthkit/man/fls.html) we can list the name of the files deleted and present on the disk.
![image](https://user-images.githubusercontent.com/65206138/172386384-8da8ed88-5817-4d40-954f-acb67971f96f.png)
- Thanks to fls, we have recovered the inode number and the name of all deleted files. So this is where the [icat](https://www.sleuthkit.org/sleuthkit/man/icat.html) tool comes into play, thanks to this, we can recover the content of a file thanks to its inode whether it is deleted or not
![image](https://user-images.githubusercontent.com/65206138/172389280-0c6bd00e-e9ba-4c41-a51c-e35ee2f4fce0.png)
- So we do this to all the files and then analyze them
![image](https://user-images.githubusercontent.com/65206138/172391744-7301d45f-3258-451b-bb26-ec22458db815.png)
- And now, thanks to this technique, we were able to recover all the files present in the USB key as well as the one including the flag



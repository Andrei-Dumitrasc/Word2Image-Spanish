import re
import os

f1 = open("../../uploads/input.txt", "r", -1, "UTF-8")
orig_text = f1.read()
orig_text = orig_text.replace("\n", "\n\n")
f1.close()

f1 = open("../../intermediary_files/replacementList.txt", "r", -1, "UTF-8")
replacements = f1.read()
f1.close()
repl_lines = replacements.split("\n")
separator = r'\s!"#$%&()*+,./:;<=>?@[\]^_`{|}~'

new_text = orig_text[:]
for line in repl_lines:
    parts = line.split(";")  # or , instead of ;
    words = [word.strip() for word in parts[0:-1]]
    imgname = parts[-1].split(".")[0].strip();
    for word in words:
        pattern = re.compile("(?<!wimgup{)(?<=[" + separator + "])*" + re.escape(word) + "(?=[" + separator + "])",
                             re.IGNORECASE)
        # pattern = re.compile("([\\s,.;:?<>])" + re.escape(word) + "(?=\1)", re.IGNORECASE)
        new_text = re.sub(pattern, r" $\\wimgup{" + imgname + "} $", new_text)

h = open("../../latex/header.txt", "r", -1, "UTF-8")
head_text = h.read()
h.close()

f = open("../../latex/footer.txt", "r", -1, "UTF-8")
foot_text = f.read()
f.close()

o = open("../../latex/output.tex", "w", -1, "UTF-8")
o.write(head_text + new_text)
o.write("\n \\\\ \\vspace*{\\fill} \\pagebreak \\vspace*{\\fill} \n \\\\  \n")
o.write(orig_text + foot_text)
o.close()

os.system('cd ../../latex && xelatex output.tex -interaction=batchmode')
# os.system('cd ../../latex && xelatex output.tex ')
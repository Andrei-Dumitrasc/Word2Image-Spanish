import re
import os
import json

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
for line in repl_lines[:-1]:
    jsonobj = json.loads(line)
    parts = list(jsonobj.keys())
    words = [k  for k,v in jsonobj.items() if v!='image']
    imgname = [k  for k,v in jsonobj.items() if v=='image'][0]
    for word in words:
        pattern = re.compile(r"(?<!wimgup{)(?<=[" + separator + r"])*\b" + re.escape(word) + r"\b(?=[" + separator + r"])*",
                             re.IGNORECASE)
        # pattern = re.compile("([\\s,.;:?<>])" + re.escape(word) + "(?=\1)", re.IGNORECASE)
        new_text = re.sub(pattern, r" $\\wimgup{" + imgname + "} $", new_text)

art_def={'f':'la','m':'el','fpl':'las','mpl':'los'}		
art_indef={'f':'una','mv':'un','mc':'uno','fpl':'unas','mpl':'unos'}
adj_dem_prox={'f':'esta','m':'este','fpl':'estas','mpl':'estos'}		
adj_dem_mid={'f':'esa','m':'ese','fpl':'esas','mpl':'esos'}		
adj_dem_dist={'f':'aquella','m':'aquel','fpl':'aquellas','mpl':'aquellos'}		
		
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
import re
import requests
import sys


def get_spanish_forms(word):
    base_link = 'https://www.wordreference.com/gramatica/'
    final_link = base_link + word
    page = requests.get(final_link)
    source_code = str(page.content, 'utf-8')

    if source_code.find('Inflexiones') < 0:
        return {word: ''}

    source_lines = source_code.split('\r\n')
    inflexiones = [line for line in source_lines if line[0:19] == '<strong>Inflexiones'][0]

    # split1 = inflexiones.split(': ')
    # words1 = [re.search(r'[a-z]+', item).group() for item in split1]
    # words1_ex = [item for item in words1 if item not in ['span', 'strong', 'px']]

    # words2 = [re.search(r'[a-z]+', item).group() for item in split2][1:] [29:]
    split1 = inflexiones.split(r"Inflexiones</strong> de '<strong>")
    base_forms = [re.search(r'\w+', item).group() for item in split1[1:]]
    base_types = [re.search(r"(?<='>)[\w, ]+(?=<)", item).group() for item in split1[1:]]
    basics = dict(zip(base_forms, base_types))

    split2 = inflexiones.split(r"POS2'> ")
    word2_notail = [re.search(r'\w+</span>: \w+', item).group() for item in split2[1:]]
    pairs = dict(
        [(re.search(r' \w+', item).group().strip(), re.search(r'\w+', item).group()) for item in word2_notail])
    pairs.update(basics)
    return pairs


word = sys.argv[1]
# word = "niña"
# word = "en"

d = get_spanish_forms(word)
# print(d)
key_str = str(list(d.keys()))
key_str = key_str.replace(r"'", "")[1:-1]
# print(key_str)

o = open("../../intermediary_files/SpanishForms.txt", "w", -1, "UTF-8")
o.write(key_str)
o.close()

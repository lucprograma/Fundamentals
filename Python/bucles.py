"""
Hay dos tipos  de bucles en Python:
1. for
2. while
"""
for i in range(10):
    print(i)

i = 0
while i < 10:
    print(i)
    i += 1
# En Python no existe el do while, pero se puede simular con un while
# do while
i = 0
while True:
    print(i)
    i += 1
    if i >= 10:
        break
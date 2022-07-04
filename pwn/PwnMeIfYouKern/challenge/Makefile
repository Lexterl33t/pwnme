obj-m += PwnMeIfYouKern.o

all:
	make -C ../vm/builds/linux M=$(PWD) modules

clean:
	make -C ../vm/builds/linux M=$(PWD) clean

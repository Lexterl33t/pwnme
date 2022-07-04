#include <linux/module.h>
#include <linux/version.h>
#include <linux/kernel.h>
#include <linux/types.h>
#include <linux/kdev_t.h>
#include <linux/fs.h>
#include <linux/device.h>
#include <linux/cdev.h>
#include <asm/uaccess.h>
#include <linux/slab.h>

static dev_t first;       // Global variable for the first device number
static struct cdev c_dev; // Global variable for the character device structure
static struct class *cl;  // Global variable for the device class

/**
 * @brief Element of the linked list.
 */
struct element_s
{
    char content[0x100];
    size_t size;
    struct element_s *next;
};

/**
 * @brief The linked list.
 */
struct list_s
{
    struct element_s *head;
    size_t size;
};

struct list_s list;

/**
 * @brief Open the device file.
 *
 * @param i The inode structure.
 * @param f The file structure.
 * @return 0 on success, error code otherwise.
 */
static int pwnmeifyoukern_open(struct inode *i, struct file *f)
{
    printk(KERN_INFO "PwnMeIfYouKern: open()\n");
    return 0;
}

/**
 * @brief Close the device file.
 *
 * @param i The inode structure.
 * @param f The file structure.
 * @return 0 on success, error code otherwise.
 */
static int pwnmeifyoukern_close(struct inode *i, struct file *f)
{
    printk(KERN_INFO "PwnMeIfYouKern: close()\n");
    return 0;
}

/**
 * @brief Read from the device file.
 *
 * @param f The file structure.
 * @param buf The user buffer.
 * @param len The length of the user buffer.
 * @param off The offset.
 * @return The number of bytes read.
 */
static ssize_t pwnmeifyoukern_read(struct file *f, char __user *buf, size_t len, loff_t *off)
{
    size_t tot = 0;      // Total number of bytes read
    struct element_s *e; // Current element
    size_t i = 0;        // Current index

    printk(KERN_INFO "PwnMeIfYouKern: read()\n");

    for (i = 0, e = list.head; i < list.size; e = e->next, i++)
    {
        // Compute how many bytes to copy from the element
        size_t buf_len = e->size;
        if (tot + buf_len > len)
            buf_len = len - tot;

        // Copy the content of the element to the user buffer
        if (copy_to_user(buf + tot, e->content, buf_len))
            return -EFAULT;

        // Update the total number of bytes read
        tot += buf_len;

        // If we have read all the bytes, break
        if (tot == len)
            break;
    }

    return tot;
}

/**
 * @brief Write to the device file.
 *
 * @param f The file structure.
 * @param buf The user buffer.
 * @param len The length of the user buffer.
 * @param off The offset.
 * @return The number of bytes written.
 */
static ssize_t pwnmeifyoukern_write(struct file *f, const char __user *buf, size_t len, loff_t *off)
{
    char *bufk;          // Kernel buffer
    int i;               // Current index
    int index;           // Index of the element to write to
    struct element_s *e; // Current element

    printk(KERN_INFO "PwnMeIfYouKern: write()\n");

    // Allocate a kernel buffer
    bufk = kmalloc(len, GFP_KERNEL);
    if (!bufk)
        return -ENOMEM;

    // Copy the user buffer to the kernel buffer
    if (copy_from_user(bufk, buf, len))
    {
        kfree(bufk);
        return -EFAULT;
    }

    // Check which action to perform
    switch (((int *)bufk)[0])
    {
    case 0:
        // Change the content of an element
        index = ((int *)bufk)[1];

        // Check if the index is valid
        if (index < 0 || index >= list.size)
        {
            kfree(bufk);
            return -EINVAL;
        }

        // Get the element to change
        e = list.head;
        for (i = 0; i < index; i++)
            e = e->next;

        // Change the content of the element
        memcpy(e->content, bufk + sizeof(int) * 2, len - sizeof(int) * 2);
        e->size = len - sizeof(int) * 2;

        break;

    case 1:
        // Add an element to the list

        // Allocate a new element
        e = kmalloc(sizeof(struct element_s) + len - sizeof(int), GFP_KERNEL);
        if (!e)
        {
            kfree(bufk);
            return -ENOMEM;
        }

        // Copy the content of the user buffer to the new element
        memcpy(e->content, bufk + sizeof(int), len - sizeof(int));
        e->size = len - sizeof(int);

        // Add the new element to the list
        e->next = list.head;
        list.head = e;

        // Update the size of the list
        list.size++;

        break;

    default:
        // Invalid action
        kfree(bufk);
        return -EINVAL;
    }

    // Free the kernel buffer
    kfree(bufk);

    return len;
}

/**
 * @brief The file operations structure.
 */
static struct file_operations pwnmeifyoukern_fops = {
    .owner = THIS_MODULE,
    .open = pwnmeifyoukern_open,
    .release = pwnmeifyoukern_close,
    .read = pwnmeifyoukern_read,
    .write = pwnmeifyoukern_write,
};

/**
 * @brief Initialize the module.
 *
 * @return 0 on success, error code otherwise.
 */
static int __init pwnmeifyoukern_init(void)
{
    printk(KERN_INFO "PwnMeIfYouKern registered");

    list.head = NULL;

    if (alloc_chrdev_region(&first, 0, 1, "pwnmeifyoukern") < 0)
    {
        return -1;
    }
    if ((cl = class_create(THIS_MODULE, "chardrv")) == NULL)
    {
        unregister_chrdev_region(first, 1);
        return -1;
    }
    if (device_create(cl, NULL, first, NULL, "pwnmeifyoukern") == NULL)
    {
        printk(KERN_INFO "PwnMeIfYouKern error");
        class_destroy(cl);
        unregister_chrdev_region(first, 1);
        return -1;
    }
    cdev_init(&c_dev, &pwnmeifyoukern_fops);
    if (cdev_add(&c_dev, first, 1) == -1)
    {
        device_destroy(cl, first);
        class_destroy(cl);
        unregister_chrdev_region(first, 1);
        return -1;
    }

    printk(KERN_INFO "<Major, Minor>: <%d, %d>\n", MAJOR(first), MINOR(first));
    return 0;
}

/**
 * @brief Cleanup the module.
 */
static void __exit pwnmeifyoukern_exit(void)
{
    printk(KERN_INFO "PwnMeIfYouKern unregistered");
    device_destroy(cl, first);
    class_destroy(cl);
    cdev_del(&c_dev);
    unregister_chrdev_region(first, 1);
}

module_init(pwnmeifyoukern_init);
module_exit(pwnmeifyoukern_exit);

MODULE_LICENSE("GPL");
MODULE_AUTHOR("ValekoZ");
MODULE_DESCRIPTION("PwnMeIfYouKern module");

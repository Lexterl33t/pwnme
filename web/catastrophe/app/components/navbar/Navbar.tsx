import Image from 'next/image'
import Link from 'next/link'

export default function Navbar() {
    return (
        <>
            <nav className="relative w-full flex flex-wrap items-center justify-between py-4 bg-gray-800 text-teal-400 hover:text-teal-500 focus:text-teal-400 shadow-lg">
                <div className="container-fluid w-full flex flex-wrap items-center justify-between px-6">
                    <p>Whiskas &gt; OSCP</p>
                    <div className="container-fluid">
                        <Link href="/api/delete">
                            <Image src="/images/cat_1.png" height="50%" width="50%" loading="lazy" />
                        </Link>
                    </div>
                    <p>Cat@Strophe</p>
                </div>
            </nav>
        </>
    )
}
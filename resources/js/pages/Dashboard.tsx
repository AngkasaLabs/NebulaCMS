import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { FileText, FolderTree, Tag, Image, ArrowUp, ArrowDown, Plus, Calendar, Clock } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Progress } from '@/components/ui/progress';

interface Stats {
    posts: {
        total: number;
        published: number;
        draft: number;
        trend: number;
    };
    categories: {
        total: number;
        trend: number;
    };
    tags: {
        total: number;
        trend: number;
    };
    media: {
        total: number;
        trend: number;
    };
}

interface RecentPost {
    id: number;
    title: string;
    status: 'published' | 'draft';
    created_at: string;
    author: {
        name: string;
    };
}

interface RecentMedia {
    id: number;
    name: string;
    url: string;
    mime_type: string;
    created_at: string;
}

interface Props {
    stats: Stats;
    recentPosts: RecentPost[];
    recentMedia: RecentMedia[];
}

export default function Dashboard({
    stats = {
        posts: { total: 0, published: 0, draft: 0, trend: 0 },
        categories: { total: 0, trend: 0 },
        tags: { total: 0, trend: 0 },
        media: { total: 0, trend: 0 }
    },
    recentPosts = [],
    recentMedia = []
}: Props) {
    const hasNoContent = stats.posts.total === 0 &&
                        stats.categories.total === 0 &&
                        stats.tags.total === 0 &&
                        stats.media.total === 0;

    if (hasNoContent) {
        return (
            <AppLayout>
                <Head title="Dashboard" />

                <div className="p-4">
                    <div className="flex flex-col items-center justify-center py-12 px-4 border rounded-lg">
                        <FileText className="h-12 w-12 text-gray-400 mb-4" />
                        <h3 className="text-lg font-medium mb-1">Welcome to NebulaCMS</h3>
                        <p className="text-center mb-8 max-w-md">
                            Start with your first content. You can create posts, categories, tags, or upload media.
                        </p>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <Link href="/admin/posts/create">
                                <Button className="w-full">
                                    <FileText className="mr-2 h-4 w-4" />
                                    Create Post
                                </Button>
                            </Link>
                            <Link href="/admin/categories/create">
                                <Button className="w-full">
                                    <FolderTree className="mr-2 h-4 w-4" />
                                    Create Category
                                </Button>
                            </Link>
                            <Link href="/admin/tags/create">
                                <Button className="w-full">
                                    <Tag className="mr-2 h-4 w-4" />
                                    Create Tag
                                </Button>
                            </Link>
                            <Link href="/admin/media">
                                <Button className="w-full">
                                    <Image className="mr-2 h-4 w-4" />
                                    Upload Media
                                </Button>
                            </Link>
                        </div>
                    </div>
                </div>
            </AppLayout>
        );
    }

    return (
        <AppLayout>
            <Head title="Dashboard" />

            <div className="p-4 space-y-4">
                {/* Stats Grid */}
                <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between pb-2">
                            <CardTitle className="text-sm font-medium">Posts</CardTitle>
                            <FileText className="h-4 w-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{stats.posts.total}</div>
                            <div className="mt-2">
                                <Progress
                                    value={(stats.posts.published / stats.posts.total) * 100}
                                    className="h-2"
                                />
                            </div>
                            <div className="grid grid-cols-2 gap-2 mt-2">
                                <div className="text-xs">
                                    <span className="text-green-500">●</span> Published
                                    <div className="font-semibold">{stats.posts.published}</div>
                                </div>
                                <div className="text-xs">
                                    <span className="text-yellow-500">●</span> Draft
                                    <div className="font-semibold">{stats.posts.draft}</div>
                                </div>
                            </div>
                            <div className="mt-3 flex items-center text-xs">
                                {stats.posts.trend > 0 ? (
                                    <ArrowUp className="h-4 w-4 text-green-500" />
                                ) : (
                                    <ArrowDown className="h-4 w-4 text-red-500" />
                                )}
                                <span className={stats.posts.trend > 0 ? 'text-green-500' : 'text-red-500'}>
                                    {Math.abs(stats.posts.trend)}% from the previous month
                                </span>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between pb-2">
                            <CardTitle className="text-sm font-medium">Categories</CardTitle>
                            <FolderTree className="h-4 w-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{stats.categories.total}</div>
                            <div className="text-xs text-muted-foreground mt-1">
                                Digunakan untuk mengorganisir konten
                            </div>
                            <div className="mt-3 flex items-center text-xs">
                                {stats.categories.trend > 0 ? (
                                    <ArrowUp className="h-4 w-4 text-green-500" />
                                ) : (
                                    <ArrowDown className="h-4 w-4 text-red-500" />
                                )}
                                <span className={stats.categories.trend > 0 ? 'text-green-500' : 'text-red-500'}>
                                    {Math.abs(stats.categories.trend)}% from the previous month
                                </span>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between pb-2">
                            <CardTitle className="text-sm font-medium">Tags</CardTitle>
                            <Tag className="h-4 w-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{stats.tags.total}</div>
                            <div className="text-xs text-muted-foreground mt-1">
                                Help in searching content
                            </div>
                            <div className="mt-3 flex items-center text-xs">
                                {stats.tags.trend > 0 ? (
                                    <ArrowUp className="h-4 w-4 text-green-500" />
                                ) : (
                                    <ArrowDown className="h-4 w-4 text-red-500" />
                                )}
                                <span className={stats.tags.trend > 0 ? 'text-green-500' : 'text-red-500'}>
                                    {Math.abs(stats.tags.trend)}% from the previous month
                                </span>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between pb-2">
                            <CardTitle className="text-sm font-medium">Media</CardTitle>
                            <Image className="h-4 w-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{stats.media.total}</div>
                            <div className="text-xs text-muted-foreground mt-1">
                                Uploaded media files
                            </div>
                            <div className="mt-3 flex items-center text-xs">
                                {stats.media.trend > 0 ? (
                                    <ArrowUp className="h-4 w-4 text-green-500" />
                                ) : (
                                    <ArrowDown className="h-4 w-4 text-red-500" />
                                )}
                                <span className={stats.media.trend > 0 ? 'text-green-500' : 'text-red-500'}>
                                    {Math.abs(stats.media.trend)}% from the previous month
                                </span>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Recent Content Grid */}
                <div className="grid gap-4 md:grid-cols-2">
                    {/* Recent Posts */}
                    <Card>
                        <CardHeader>
                            <CardTitle>Recent Posts</CardTitle>
                        </CardHeader>
                        <CardContent>
                            {recentPosts.length === 0 ? (
                                <div className="flex flex-col items-center justify-center py-8">
                                    <FileText className="h-8 w-8 text-gray-400 mb-2" />
                                    <p className="text-sm text-gray-400 text-center mb-4">No posts yet</p>
                                    <Link href="/posts/create">
                                        <Button variant="outline" size="sm">
                                            <Plus className="mr-2 h-4 w-4" />
                                            Create Post
                                        </Button>
                                    </Link>
                                </div>
                            ) : (
                            <div className="space-y-4">
                                {recentPosts.map(post => (
                                    <div key={post.id} className="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                        <div className="space-y-1">
                                            <p className="text-sm font-medium leading-none">{post.title}</p>
                                            <div className="flex items-center space-x-2 text-xs text-muted-foreground">
                                                <span className="flex items-center">
                                                    <Calendar className="h-3 w-3 mr-1" />
                                                    {new Date(post.created_at).toLocaleDateString('id-ID')}
                                                </span>
                                                <span>•</span>
                                                <span className="flex items-center">
                                                    <Clock className="h-3 w-3 mr-1" />
                                                    {new Date(post.created_at).toLocaleTimeString('id-ID')}
                                                </span>
                                            </div>
                                        </div>
                                        <div className="ml-auto flex items-center">
                                            <span className={`px-2 py-1 rounded-full text-xs ${
                                                post.status === 'published'
                                                    ? 'bg-green-100 text-green-700'
                                                    : 'bg-yellow-100 text-yellow-700'
                                            }`}>
                                                {post.status === 'published' ? 'Published' : 'Draft'}
                                            </span>
                                        </div>
                                    </div>
                                ))}
                            </div>
                            )}
                        </CardContent>
                    </Card>

                    {/* Recent Media */}
                    <Card>
                        <CardHeader>
                            <CardTitle>Recent Media</CardTitle>
                        </CardHeader>
                        <CardContent>
                            {recentMedia.length === 0 ? (
                                <div className="flex flex-col items-center justify-center py-8">
                                    <Image className="h-8 w-8 text-gray-400 mb-2" />
                                    <p className="text-sm text-gray-400 text-center mb-4">No media yet</p>
                                    <Link href="/media">
                                        <Button variant="outline" size="sm">
                                            <Plus className="mr-2 h-4 w-4" />
                                            Upload Media
                                        </Button>
                                    </Link>
                                </div>
                            ) : (
                            <div className="grid grid-cols-4 gap-4">
                                {recentMedia.map(media => (
                                    <div key={media.id} className="relative aspect-square group">
                                        {media.mime_type?.startsWith('image/') ? (
                                            <img
                                                src={media.url}
                                                alt={media.name}
                                                className="w-full h-full object-cover rounded-lg"
                                            />
                                        ) : (
                                            <div className="w-full h-full flex items-center justify-center bg-gray-100 rounded-lg">
                                                <FileText className="h-6 w-6 text-gray-400" />
                                            </div>
                                        )}
                                        <div className="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                            <p className="text-white text-xs text-center px-2 truncate">
                                                {media.name}
                                            </p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                            )}
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}
